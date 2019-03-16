/* *
 * audio visualizer with html5 audio element
 *
 * v0.1.0
 *
 * licenced under the MIT license
 *
 * see my related repos:
 * - HTML5_Audio_Visualizer https://github.com/wayou/HTML5_Audio_Visualizer
 * - 3D_Audio_Spectrum_VIsualizer https://github.com/wayou/3D_Audio_Spectrum_VIsualizer
 * - selected https://github.com/wayou/selected
 * - MeowmeowPlayer https://github.com/wayou/MeowmeowPlayer
 *
 * reference: http://www.patrick-wied.at/blog/how-to-create-audio-visualizations-with-javascript-html
 */


/**
 * https://github.com/wayou/audio-visualizer-with-controls
 * @type {[type]}
 */

window.AudioContext = window.AudioContext || window.webkitAudioContext || window.mozAudioContext;


window.audioVis2D = function(elm, usrOpts) {
    var $wrapper = document.querySelector(elm);
    if(!$wrapper)
      return false;

    var $audio = $wrapper.getElementsByClassName('audio-player__player')[0];
    var $canvas = $wrapper.getElementsByClassName('audio-player__visualizer')[0];
    if(!$audio || !$canvas)
      return false;


    var root = document.querySelector(':root');
    var rootStyles = getComputedStyle(root);


    var options = {
      gap: 5,
      capHeight: 2,
      colWidth: 5,
      capColor: rootStyles.getPropertyValue('--gray-lighter') || '#fff',
      topColor: rootStyles.getPropertyValue('--brand-primary') || '#0012ff',
      middleColor: rootStyles.getPropertyValue('--brand-warning') || '#ff0',
      bottomColor: rootStyles.getPropertyValue('--brand-danger') || '#0f0'
    };
    options = Object.assign(options, usrOpts);


    var ctx = ctx || new AudioContext();
    var analyser = ctx.createAnalyser();
    var audioSrc = ctx.createMediaElementSource($audio);

    // we have to connect the MediaElementSource with the analyser
    audioSrc.connect(analyser);
    analyser.connect(ctx.destination);
    // we could configure the analyser: e.g. analyser.fftSize (for further infos read the spec)
    // analyser.fftSize = 64;
    // frequencyBinCount tells you how many values you'll receive from the analyser
    var frequencyData = new Uint8Array(analyser.frequencyBinCount);



    var cwidth = $canvas.offsetWidth;
    var cheight = $canvas.offsetHeight - 2;
    var meterNum = cwidth / (options.colWidth + options.gap); //count of the meters
    // console.log($canvas.offsetWidth, $canvas.width, colWidth, gap, meterNum );
    var capYPositionArray = []; ////store the vertical position of hte caps for the preivous frame
    var ctx = $canvas.getContext('2d');
    var gradient = ctx.createLinearGradient(0, 0, 0, 300);

    gradient.addColorStop( 0, options.topColor );
    gradient.addColorStop( 0.5, options.middleColor );
    gradient.addColorStop( 1, options.bottomColor );

    // loop
    function renderFrame() {
        var array = new Uint8Array(analyser.frequencyBinCount);
        analyser.getByteFrequencyData(array);
        var step = Math.round(array.length / meterNum); //sample limited data from the total array

        ctx.clearRect(0, 0, cwidth, cheight);

        for (var i = 0; i < meterNum; i++) {
            var value = array[i * step];
            if (capYPositionArray.length < Math.round(meterNum)) {
                capYPositionArray.push(value);
            };
            ctx.fillStyle = options.capStyle;
            //draw the cap, with transition effect
            if (value < capYPositionArray[i]) {
                ctx.fillRect(i * 12, cheight - (--capYPositionArray[i]), options.colWidth, options.capHeight);
            } else {
                ctx.fillRect(i * 12, cheight - value, options.colWidth, options.capHeight);
                capYPositionArray[i] = value;
            };
            ctx.fillStyle = gradient; //set the filllStyle to gradient for a better look
            ctx.fillRect(i * 12 /*options.colWidth+options.gap*/ , cheight - value + options.capHeight, options.colWidth, cheight); //the meter
        }
        requestAnimationFrame(renderFrame);
    }
    renderFrame();
    // $audio.play();
};
