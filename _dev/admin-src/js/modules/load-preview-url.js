function randomString(length, chars) {
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}

function toggle404Page(api, isExpanded){
    var rand = randomString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
    var randNum = randomString(32, '0123456789');
    var url = api.settings.url.home + rand;

    if ( isExpanded ) {
        api.previewer.previewUrl.set( url + '?p=' + randNum );
    }else {
        url = api.settings.url.home;
        api.previewer.previewUrl.set( url + '?p=' + randNum );
    }
}


(function ( api ) {

    /**
     * Load a fake page when we open a 404 settings section, load the front page when we leave
     */
    api.section( '_404_settings_section', function( section ) {
        section.expanded.bind( function( isExpanded ) {
            toggle404Page(api, isExpanded);
        } );
    } );


    /**
     * Load a fake page when we open a 404 settings section, load the front page when we leave
     */
    api.section( '_404_content_section', function( section ) {
        section.expanded.bind( function( isExpanded ) {
            toggle404Page(api, isExpanded);
        } );
    } );

    /**
     * Load the front page when we goto the frontpage template settings section
     */
    api.section( 'frontpage_settings_section', function( section ) {
        section.expanded.bind( function( isExpanded ) {
            var url = api.settings.url.home ;

            var previousUrl = api.previewer.previewUrl.get();
            if ( isExpanded ) {
                api.previewer.previewUrl.set( url );
            }
        } );
    } );

} ( wp.customize ) );
