
// javascript for front end of the block

document.addEventListener( 'DOMContentLoaded', () => {

    // retrieve pointer to all instances of the custom block
    const allLists = document.querySelectorAll( '.demoblock-simple__category' );

    // if there do not seem to be any block instances, do nothing further
	if ( ! allLists.length ) {
		return;
    }

    // loop through each instance of the block on the page
    allLists.forEach( ( list ) => {

        // inject a button element into the block
        const reverseButton = document.createElement('button');
        reverseButton.textContent = 'Reverse Order';
        reverseButton.type = 'button';
        list.appendChild(reverseButton);

        // add a click handler to the button that reverses the list items within
        reverseButton.addEventListener( 'click', () => {
            Array.from(list.children).reverse().forEach(li => list.appendChild(li));
        });

    });

});