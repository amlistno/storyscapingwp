jQuery(document).ready(function($){

    // Menu interactions
    $( '#primary-menu li:has(ul)' ).addClass( 'parent' ).append( '<span class="genericon genericon-expand caret"></span>' );
    $( '#primary-menu span' ).click( function() {
        $( this ).prev( '.sub-menu' ).toggleClass( 'open' );
        $( this ).toggleClass( 'focus' );
    });

});