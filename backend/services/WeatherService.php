<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../utils/exceptions.php';
require_once __DIR__ . '/../utils/Validator.php';

class WeatherService
{
    private function request($url)
    {
        $this->write_log('info', 'External API request ' . $url);
        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => (int) Config::OPEN_METEO_TIMEOUT(),
            CURLOPT_CONNECTTIMEOUT => (int) Config::OPEN_METEO_TIMEOUT(),
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
        ]);
        $body = curl_exec($curl);
        $error = curl_error($curl);
        $status = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($body === false || $error || $status < 200 || $status >= 300) {
            $this->write_log('error', 'External API failure ' . $url . ' status=' . $status . ' error=' . $error);
            throw new ExternalServiceException('The weather service is temporarily unavailable.');
        }

        $data = json_decode($body, true);
        if (!is_array($data)) {
            $this->write_log('error', 'External API returned invalid JSON ' . $url);
            throw new ExternalServiceException('The weather service returned an invalid response.');
        }

        return $data;
    }

    private function write_log($level, $message)
    {
        $file = __DIR__ . '/../logs/' . ($level === 'error' ? 'error.log' : 'info.log');
        error_log('[' . date('Y-m-d H:i:s') . '] ' . strtoupper($level) . ' ' . $message . PHP_EOL, 3, $file);
    }

    public function forecast($city, $days = 7)
    {
        if (trim((string) $city) === '') {
            throw new ValidationException("Query parameter 'city' is required.");
        }
        Validator::integer($days, 'days', 1, 7);
        $city = trim($city);
        $locations = $this->request(Config::OPEN_METEO_GEOCODING_URL() . '?' . http_build_query([
            'name' => $city,
            'count' => 1,
            'language' => 'en',
            'format' => 'json',
        ]));
        if (empty($locations['results'][0])) {
            throw new NotFoundException("No city called '$city' was found.");
        }

        $location = $locations['results'][0];
        $weather = $this->request(Config::OPEN_METEO_FORECAST_URL() . '?' . http_build_query([
            'latitude' => $location['latitude'],
            'longitude' => $location['longitude'],
            'daily' => 'weather_code,temperature_2m_max,temperature_2m_min',
            'forecast_days' => (int) $days,
            'timezone' => 'auto',
        ]));
        $daily = $weather['daily'] ?? [];
        $result_days = [];
        for ($i = 0; $i < count($daily['time'] ?? []); $i++) {
            $code = (int) $daily['weather_code'][$i];
            $result_days[] = [
                'date' => $daily['time'][$i],
                'weather_code' => $code,
                'description' => $this->description($code),
                'icon' => $this->icon($code),
                'temperature_max' => $daily['temperature_2m_max'][$i],
                'temperature_min' => $daily['temperature_2m_min'][$i],
            ];
        }

        return [
            'city' => $location['name'],
            'country' => $location['country'] ?? null,
            'latitude' => $location['latitude'],
            'longitude' => $location['longitude'],
            'days' => $result_days,
        ];
    }

    private function description($code)
    {
        if ($code === 0) return 'Clear sky';
        if (in_array($code, [1, 2, 3], true)) return 'Partly cloudy';
        if (in_array($code, [45, 48], true)) return 'Fog';
        if ($code >= 51 && $code <= 67) return 'Rain';
        if ($code >= 71 && $code <= 77) return 'Snow';
        if ($code >= 80 && $code <= 82) return 'Rain showers';
        if ($code >= 85 && $code <= 86) return 'Snow showers';
        if ($code >= 95) return 'Thunderstorm';

        return 'Mixed conditions';
    }

    private function icon($code)
    {
        if ($code === 0) return 'sun';
        if ($code >= 95) return 'cloud-lightning';
        if ($code >= 71 && $code <= 86) return 'cloud-snow';
        if ($code >= 51 && $code <= 67 || $code >= 80 && $code <= 82) return 'cloud-rain';

        return 'cloud';
    }
}
