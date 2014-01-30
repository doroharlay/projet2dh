$(window).load(function() {
            $('#main-slider').flexslider({
                animation: "slide",
                controlNav: false,
                prevText: "",
                nextText: ""
            });
            $('#secondary-slider').flexslider({
                animation: "slide",
                controlNav: false,
                prevText: "",
                nextText: ""
            });
        });

$(document).ready(function() {
            $('.tooltip').tooltipster();
        });


// événements menus

$('.menu').on('click', anim_menu);
$('.menu_presse').on('click', anim_menu_presse);

// événements tooltip

$('.option').on('mouseover', affiche_tooltip);
$('.option').on('mouseout', masque_tooltip);
$('.option').on('taphold', tooltip_mobile);



// gestionnaires d'événements menus

function anim_menu(e) {
    $('.nav_mobile').toggleClass('invisible');
}
function anim_menu_presse(e) {
    $('.presse_mobile').toggleClass('invisible');
}

// gestionnaires d'événements tooltip

function affiche_tooltip(e) {
    $(this).find('.tooltip_aspect').removeClass('tooltip_invisible');
}
function masque_tooltip(e) {
    $(this).find('.tooltip_aspect').addClass('tooltip_invisible');
}
function tooltip_mobile(e) {
    alert('test');
    $(this).find('.tooltip_aspect').toggleClass('tooltip_invisible');
}

// détection taille écran

(function() {

    // Create the ViewPort detector
    var viewDetector = document.createElement('div');
    document.getElementsByTagName('body')[0].insertBefore(viewDetector).id = 'viewport-detector';
    
    // Load and Resize events
    window.onresize = dynamicResizer;
    window.onload = dynamicResizer;

    function dynamicResizer() {
        var docWidth = window.innerWidth,
            docHeight = window.innerHeight;
        spanDimensions.innerHTML = docWidth + " x " + docHeight;
    }
    
    // Create <span class="dimensions"> and append
    var spanDimensions = document.createElement('span');
    spanDimensions.className = 'dimensions';
    document.getElementById('viewport-detector').appendChild(spanDimensions);
    
    // Create <span class="retina"> and append
    var spanRetina = document.createElement('span');
    spanRetina.className = 'retina';
    document.getElementById('viewport-detector').appendChild(spanRetina);
    
    // Create <span class="pixel-ratio"> and append
    var spanPixels = document.createElement('span');
    spanPixels.className = 'pixel-ratio';
    document.getElementById('viewport-detector').appendChild(spanPixels);
    spanPixels.innerHTML = 'Pixel Ratio: ' + window.devicePixelRatio;
    
    // Retina detect
    if(window.devicePixelRatio >= 2) {
        spanRetina.innerHTML = 'Retina Device';
    } else {
        spanRetina.innerHTML = 'No Retina Device';
    }
})();