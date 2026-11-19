<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../utils/exceptions.php';
require_once __DIR__ . '/../utils/Validator.php';

class OpenMeteoService
{
    private const MAX_FORECAST_DAYS = 16;
    private const UNAVAILABLE = 'The weather service is not available at the moment. Please try again later.';

    /** WMO weather codes -> text + Bootstrap Icon. */
    private const WEATHER_CODES = [
        0 => ['Clear sky', 'sun'],
        1 => ['Mainly clear', 'cloud-sun'], 2 => ['Partly cloudy', 'cloud-sun'], 3 => ['Overcast', 'clouds'],
        45 => ['Fog', 'cloud-fog'], 48 => ['Fog', 'cloud-fog'],
        51 => ['Light drizzle', 'cloud-drizzle'], 53 => ['Drizzle', 'cloud-drizzle'], 55 => ['Heavy drizzle', 'cloud-drizzle'],
        56 => ['Freezing drizzle', 'cloud-drizzle'], 57 => ['Freezing drizzle', 'cloud-drizzle'],
        61 => ['Light rain', 'cloud-rain'], 63 => ['Rain', 'cloud-rain'], 65 => ['Heavy rain', 'cloud-rain-heavy'],
        66 => ['Freezing rain', 'cloud-sleet'], 67 => ['Freezing rain', 'cloud-sleet'],
        71 => ['Light snow', 'cloud-snow'], 73 => ['Snow', 'cloud-snow'], 75 => ['Heavy snow', 'cloud-snow'], 77 => ['Snow grains', 'cloud-snow'],
        80 => ['Rain showers', 'cloud-rain'], 81 => ['Rain showers', 'cloud-rain'], 82 => ['Violent rain showers', 'cloud-rain-heavy'],
        85 => ['Snow showers', 'cloud-snow'], 86 => ['Snow showers', 'cloud-snow'],
        95 => ['Thunderstorm', 'cloud-lightning-rain'], 96 => ['Thunderstorm with hail', 'cloud-lightning-rain'], 99 => ['Thunderstorm with hail', 'cloud-lightning-rain']
    ];

    public function geocode($city)
    {
        $city = trim((string) $city);
        if (mb_strlen($city) < 2) {
            throw new ValidationException('Please enter at least 2 characters of the city name.');
        }

        $data = $this->request(Config::OPEN_METEO_GEOCODING_URL() . '/v1/search?' . http_build_query([
            'name' => $city,
            'count' => 1,
            'language' => 'en',
            'format' => 'json',
        ]));
        if (empty($data['results'][0])) {
            throw new NotFoundException("No city called '$city' was found.");
        }

        $location = $data['results'][0];

        return [
            'name' => $location['name'],
            'country' => $location['country'] ?? null,
            'latitude' => $location['latitude'],
            'longitude' => $location['longitude'],
        ];
    }

    public function forecast($city, $days = 7)
    {
        Validator::integer($days, 'days', 1, self::MAX_FORECAST_DAYS);
        $location = $this->geocode($city);
        $data = $this->request(Config::OPEN_METEO_FORECAST_URL() . '/v1/forecast?' . http_build_query([
            'latitude' => $location['latitude'],
            'longitude' => $location['longitude'],
            'daily' => 'weather_code,temperature_2m_max,temperature_2m_min,precipitation_probability_max',
            'forecast_days' => (int) $days,
            'timezone' => 'auto',
        ]));

        if (!isset($data['daily']['time']) || !is_array($data['daily']['time'])) {
            error_log('Open-Meteo response did not contain daily forecast data.');
            throw new ExternalServiceException(self::UNAVAILABLE);
        }

        $daily = $data['daily'];
        $result_days = [];
        foreach ($daily['time'] as $i => $date) {
            $code = isset($daily['weather_code'][$i]) ? (int) $daily['weather_code'][$i] : null;
            [$description, $icon] = self::WEATHER_CODES[$code] ?? ['Unknown', 'question-circle'];
            $result_days[] = [
                'date' => $date,
                'weather_code' => $code,
                'description' => $description,
                'icon' => $icon,
                'temp_max' => isset($daily['temperature_2m_max'][$i]) ? round((float) $daily['temperature_2m_max'][$i]) : null,
                'temp_min' => isset($daily['temperature_2m_min'][$i]) ? round((float) $daily['temperature_2m_min'][$i]) : null,
                'precipitation_probability' => isset($daily['precipitation_probability_max'][$i]) ? (int) $daily['precipitation_probability_max'][$i] : null,
            ];
        }

        return [
            'city' => $location['name'],
            'country' => $location['country'],
            'latitude' => $location['latitude'],
            'longitude' => $location['longitude'],
            'days' => $result_days,
        ];
    }

    private function request($url)
    {
        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_TIMEOUT => (int) Config::OPEN_METEO_TIMEOUT(),
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
        ]);
        $body = curl_exec($curl);
        $error = curl_error($curl);
        $status = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($body === false) {
            error_log('Open-Meteo request failed: ' . $error);
            throw new ExternalServiceException(self::UNAVAILABLE);
        }
        if ($status !== 200) {
            error_log('Open-Meteo returned HTTP ' . $status . '.');
            throw new ExternalServiceException(self::UNAVAILABLE);
        }

        $data = json_decode($body, true);
        if (!is_array($data)) {
            error_log('Open-Meteo returned invalid JSON.');
            throw new ExternalServiceException(self::UNAVAILABLE);
        }

        return $data;
    }
}
