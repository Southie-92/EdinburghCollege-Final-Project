<?php
	// Initialise the session
	session_start();
	/* NEW STUFF: session_destroy
	 *   As we're logging out, we want to wipe the $_SESSION array to make sure we're not leaving a potential
	 * vulnerability floating around. We do this with the simple command session_destroy.
	 *   Note that the session is only actually garunteed to vanish when we *leave* the web-page, which is why we
	 * immediately redirect somewhere else.
	 */
	session_destroy();
	header("Location: index.php");
?>