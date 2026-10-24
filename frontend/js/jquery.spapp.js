(function ($) {
  $.spapp = function (options) {
    var config;
    var routes = {};

    config = $.extend({
      defaultView: "view_home",
      templateDir: "./views/",
      pageNotFound: "view_login"
    }, options);

    this.route = function (routeOptions) {
      routes[routeOptions.view] = $.extend({
        view: routeOptions.view,
        load: routeOptions.view + ".html",
        onCreate: function () {},
        onReady: function () {}
      }, routeOptions);
    };

    var routeChange = function () {
      var hash = window.location.hash.slice(1);
      var hashParts = hash.split("?");
      var id = hashParts[0];
      var params = new URLSearchParams(hashParts[1] || "");
      var route = routes[id];
      var element = $("#spapp");

      if (!route) {
        if (config.pageNotFound) {
          window.location.hash = config.pageNotFound;
          return;
        }
        return;
      }

      element.empty().load(config.templateDir + route.load, function (response, status, xhr) {
        if (status === "error") {
          element.html("<p class=\"container py-5\">This page could not be loaded.</p>");
          return;
        }
        route.onCreate();
        route.onReady(params);
      });
    };

    this.run = function () {
      window.addEventListener("hashchange", routeChange);
      if (!window.location.hash) {
        window.location.hash = config.defaultView;
      } else {
        routeChange();
      }
    };

    return this;
  };
}(jQuery));
