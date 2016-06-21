jQuery(function () {
    jQuery('#camera_wrap_<?php echo $module; ?>').camera({
        fx: 'random',
        navigation: false,
        playPause: false,
        thumbnails: false,
        navigationHover: false,
        barPosition: 'top',
        loader: false,
        time: 3000,
        transPeriod: 800,
        alignment: 'center',
        autoAdvance: true,
        mobileAutoAdvance: true,
        barDirection: 'leftToRight',
        barPosition: 'bottom',
        easing: 'easeInOutExpo',
        height: '46.49%',
        minHeight: '90px',
        hover: true,
        pagination: true,
        loaderColor: '#1f1f1f',
        loaderBgColor: 'transparent',
        loaderOpacity: 1,
        loaderPadding: 0,
        loaderStroke: 3
    });
});