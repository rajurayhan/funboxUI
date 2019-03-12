jQuery( document ).ready( function( $ )
{

    $( '.funbox-nav-category li a' ).click( function( e )
    {
        e.preventDefault();
        $( '.funbox-nav-category' ).find( 'li.active' ).removeClass( 'active' );
        $( this ).parent( 'li' ).addClass( 'active' );
        $( '.funbox-control.left' ).trigger( 'click' );
    } );

    $( '.funbox-nav-sub-category li a' ).click( function( e )
    {
        e.preventDefault();
        $( '.funbox-nav-sub-category' ).find( 'li.active' ).removeClass( 'active' );
        $( this ).parent( 'li' ).addClass( 'active' );
        $( '.funbox-control.right' ).trigger( 'click' );
    } );

    // previous
    $( '.funbox-control.left' ).click( function( e )
    {
        e.preventDefault();
        $category_id = $( '.funbox-nav-category' ).find( 'li.active a' ).data( 'id' );
        $sub_category_id = $( '.funbox-nav-sub-category' ).find( 'li.active a' ).data( 'id' );
        $.ajax( {
            url: 'contents.php',
            type: 'post',
            data: { category_id: $category_id, sub_category_id: $sub_category_id },
            success: function( response )
            {
                $( '.contents-container' ).html( response );
            }
        } );
    } );

    // next
    $( '.funbox-control.right' ).click( function( e )
    {
        e.preventDefault();
        $category_id = $( '.funbox-nav-category' ).find( 'li.active a' ).data( 'id' );
        $sub_category_id = $( '.funbox-nav-sub-category' ).find( 'li.active a' ).data( 'id' );
        console.log( $category_id, $sub_category_id );
        $.ajax( {
            url: 'contents.php',
            type: 'post',
            data: { category_id: $category_id, sub_category_id: $sub_category_id },
            success: function( response )
            {
                $( '.contents-container' ).html( response );
            }
        } );
    } );

} );