
// js for front end of the block

document.addEventListener( 'DOMContentLoaded', () => {

    const allLists = document.querySelectorAll( '.demoblock-simple__category' );

	if ( ! allLists.length ) {
		return;
    }

    allLists.forEach( ( list ) => {
        const rotateButton = document.createElement('button');
        rotateButton.textContent = 'Rotate';
        rotateButton.type = 'button';
        list.appendChild(rotateButton);
        rotateButton.addEventListener( 'click', () => {
            if (list.classList.contains('vertical')) {
                list.classList.remove('vertical')
            } else {
                list.classList.add('vertical')
            }
        });
    });

});