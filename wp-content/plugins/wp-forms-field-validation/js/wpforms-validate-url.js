// Validate URL fields that include video links

$ = jQuery;

$(function () {

  // Check if page contains WP Form
  if ($('.wpforms-container').length) {

    $('.wpforms-field-url').each(function () {
      
      let label = $(this).find('label');
      let el = $(this);

      label = label.text().toLowerCase();

      if ( label.includes('video')) {

        // Find input field (only if URL)
        let input = $(this).find('input[type="url"'); 

        // Validate URL format on change
        $(input).blur(function () {
          let val = $(input).val();
          if (val.includes('youtube')) {
            validateYouTubeUrl(val, error(val, input));
          } else if (val.includes('vimeo')) {
            validateVimeoURL(val, error(val, input));
          }
        });
      }

    });

  }

  function validateYouTubeUrl(url) {    

    if (url != undefined || url != '') {        
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
        var match = url.match(regExp);
        if (match && match[2].length == 11) {
          // Validity check - leave empty if no action needed
          $(error).hide();
        } else {
          // Display error on invalid URL
          $(error).show();
        }
    }
  }

  function validateVimeoURL(url) {
    var VIMEO_BASE_URL = "https://vimeo.com/api/oembed.json?url=";
    var testUrl = url;

    $.ajax({
      url: VIMEO_BASE_URL + testUrl,
      type: 'GET',
      success: function(data) {
        if (data != null && data.video_id > 0) {
          // Valid Vimeo url
          console.log('valid Vimeo');
        } else {
          // not a valid Vimeo url
          console.log('invalid Vimeo');
        }
      },
      error: function(data) {
        // not a valid Vimeo url

      }
    });
  }

  function error(data, el) {

    let urlType, exampleUrl;

    console.log(data);
    if (data.includes('youtube')) {
      urlType = 'youtube';
      exampleUrl = 'https://www.youtube.com/watch?v=ABCDEFGHIJK';
    } else if (data.includes('vimeo')) {
      urlType = 'vimeo';
      exampleUrl = 'https:www.vimeo.com/12345678';
    }

    let errorMsg = '<label class="wpforms-error" style="display:none;">Please enter a valid ' + urlType + ' URL (e.g. ' + exampleUrl + ')</label>';
    $(errorMsg).insertAfter(el);
  }

});