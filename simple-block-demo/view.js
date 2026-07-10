
// javascript for front end of the block

document.addEventListener( 'DOMContentLoaded', () => {

    // retrieve pointer to all instances of the custom block
    const allDemoBlocks = document.querySelectorAll( '.simple-block-demo' );

    // if there do not seem to be any block instances, do nothing further
	if ( ! allDemoBlocks.length ) {
		return;
    }

    // loop through each instance of the block on the page
    allDemoBlocks.forEach( ( block ) => {

        // inject a reverse icon element into the block heading
        const reverseIcon = document.createElement('span');
        reverseIcon.classList = 'reverse-direction dashicons dashicons-controls-repeat';
        reverseIcon.tabIndex = 0; 
        reverseIcon.role = "button";
        reverseIcon.ariaLabel="Reverse List order";
        block.querySelector('h2').appendChild(reverseIcon);

        // add a click handler to the icon that reverses the block items within
        reverseIcon.addEventListener( 'click', () => {
            var blockList=block.querySelector('ul');
            Array.from(blockList.children).reverse().forEach(li => blockList.appendChild(li));
        });

        // also add an accessible keyboard event handler so space or enter trigger a click
        reverseIcon.addEventListener( 'keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                reverseIcon.click();
            }
        });
    });

});