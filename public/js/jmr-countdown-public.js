;(function ($) {
  'use strict'

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */
  $(function () {

    $.ajax({
      url: jmr_cd_vars.ajaxurl,
      type: 'post',
      data: {
        action: 'jmr_ajax_cdt',
      },
      success: function (data) {
        var dato = JSON.parse(data)
        var date = new Date(dato.end_date * 1000)

        $('#countdownSandbox').countdown({
          until: date,
          format: dato.format ? dato.format : '',
          compact: dato.compact ? dato.compact : true,
          description: dato.custom_msg ? dato.custom_msg : '' 
        })
      },
    })
  })
})(jQuery)
