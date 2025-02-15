<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page' );
}

/**
 * Set the default Google Fonts used in theme.
 *
 * Used to set the default Google Fonts used in the theme, when Custom Typography is disabled.
 */

global $google_fonts, $default_google_fonts;

$google_fonts = array(	
	array( 'name' => "Cantarell", 'variant' => ':r,b,i,bi'),
	array( 'name' => "Cardo", 'variant' => ''),
	array( 'name' => "Crimson Text", 'variant' => ''),
	array( 'name' => "Droid Sans", 'variant' => ':r,b'),
	array( 'name' => "Droid Sans Mono", 'variant' => ''),
	array( 'name' => "Droid Serif", 'variant' => ':r,b,i,bi'),
	array( 'name' => "IM Fell DW Pica", 'variant' => ':r,i'),
	array( 'name' => "Inconsolata", 'variant' => ''),
	array( 'name' => "Josefin Sans", 'variant' => ':400,400italic,700,700italic'),
	array( 'name' => "Josefin Slab", 'variant' => ':r,b,i,bi'),
	array( 'name' => "Lobster", 'variant' => ''),
	array( 'name' => "Molengo", 'variant' => ''),
	array( 'name' => "Nobile", 'variant' => ':r,b,i,bi'),
	array( 'name' => "OFL Sorts Mill Goudy TT", 'variant' => ':r,i'),
	array( 'name' => "Old Standard TT", 'variant' => ':r,b,i'),
	array( 'name' => "Reenie Beanie", 'variant' => ''),
	array( 'name' => "Tangerine", 'variant' => ':r,b'),
	array( 'name' => "Vollkorn", 'variant' => ':r,b'),
	array( 'name' => "Yanone Kaffeesatz", 'variant' => ':r,b'),
	array( 'name' => "Cuprum", 'variant' => ''),
	array( 'name' => "Neucha", 'variant' => ''),
	array( 'name' => "Neuton", 'variant' => ''),
	array( 'name' => "PT Sans", 'variant' => ':r,b,i,bi'),
	array( 'name' => "PT Sans Caption", 'variant' => ':r,b'),
	array( 'name' => "PT Sans Narrow", 'variant' => ':r,b'),
	array( 'name' => "Philosopher", 'variant' => ''),
	array( 'name' => "Allerta", 'variant' => ''),
	array( 'name' => "Allerta Stencil", 'variant' => ''),
	array( 'name' => "Arimo", 'variant' => ':r,b,i,bi'),
	array( 'name' => "Arvo", 'variant' => ':r,b,i,bi'),
	array( 'name' => "Bentham", 'variant' => ''),
	array( 'name' => "Coda", 'variant' => ':800'),
	array( 'name' => "Cousine", 'variant' => ''),
	array( 'name' => "Covered By Your Grace", 'variant' => ''),
	array( 'name' => "Geo", 'variant' => ''),
	array( 'name' => "Just Me Again Down Here", 'variant' => ''),
	array( 'name' => "Puritan", 'variant' => ':r,b,i,bi'),
	array( 'name' => "Raleway", 'variant' => ':100'),
	array( 'name' => "Tinos", 'variant' => ':r,b,i,bi'),
	array( 'name' => "UnifrakturCook", 'variant' => ':bold'),
	array( 'name' => "UnifrakturMaguntia", 'variant' => ''),
	array( 'name' => "Mountains of Christmas", 'variant' => ''),
	array( 'name' => "Lato", 'variant' => ':400,700,400italic'),
	array( 'name' => "Orbitron", 'variant' => ':r,b,i,bi'),
	array( 'name' => "Allan", 'variant' => ':bold'),
	array( 'name' => "Anonymous Pro", 'variant' => ':r,b,i,bi'),
	array( 'name' => "Copse", 'variant' => ''),
	array( 'name' => "Kenia", 'variant' => ''),
	array( 'name' => "Ubuntu", 'variant' => ':r,b,i,bi'),
	array( 'name' => "Vibur", 'variant' => ''),
	array( 'name' => "Sniglet", 'variant' => ':800'),
	array( 'name' => "Syncopate", 'variant' => ''),
	array( 'name' => "Cabin", 'variant' => ':400,400italic,700,700italic,'),
	array( 'name' => "Merriweather", 'variant' => ''),
	array( 'name' => "Maiden Orange", 'variant' => ''),
	array( 'name' => "Just Another Hand", 'variant' => ''),
	array( 'name' => "Kristi", 'variant' => ''),
	array( 'name' => "Corben", 'variant' => ':b'),
	array( 'name' => "Gruppo", 'variant' => ''),
	array( 'name' => "Buda", 'variant' => ':light'),
	array( 'name' => "Lekton", 'variant' => ''),
	array( 'name' => "Luckiest Guy", 'variant' => ''),
	array( 'name' => "Crushed", 'variant' => ''),
	array( 'name' => "Chewy", 'variant' => ''),
	array( 'name' => "Coming Soon", 'variant' => ''),
	array( 'name' => "Crafty Girls", 'variant' => ''),
	array( 'name' => "Fontdiner Swanky", 'variant' => ''),
	array( 'name' => "Permanent Marker", 'variant' => ''),
	array( 'name' => "Rock Salt", 'variant' => ''),
	array( 'name' => "Sunshiney", 'variant' => ''),
	array( 'name' => "Unkempt", 'variant' => ''),
	array( 'name' => "Calligraffitti", 'variant' => ''),
	array( 'name' => "Cherry Cream Soda", 'variant' => ''),
	array( 'name' => "Homemade Apple", 'variant' => ''),
	array( 'name' => "Irish Growler", 'variant' => ''),
	array( 'name' => "Kranky", 'variant' => ''),
	array( 'name' => "Schoolbell", 'variant' => ''),
	array( 'name' => "Slackey", 'variant' => ''),
	array( 'name' => "Walter Turncoat", 'variant' => ''),
	array( 'name' => "Radley", 'variant' => ''),
	array( 'name' => "Meddon", 'variant' => ''),
	array( 'name' => "Kreon", 'variant' => ':r,b'),
	array( 'name' => "Dancing Script", 'variant' => ''),
	array( 'name' => "Goudy Bookletter 1911", 'variant' => ''),
	array( 'name' => "PT Serif Caption", 'variant' => ':r,i'),
	array( 'name' => "PT Serif", 'variant' => ':r,b,i,bi'),
	array( 'name' => "Astloch", 'variant' => ':b'),
	array( 'name' => "Bevan", 'variant' => ''),
	array( 'name' => "Anton", 'variant' => ''),
	array( 'name' => "Expletus Sans", 'variant' => ':b'),
	array( 'name' => "VT323", 'variant' => ''),
	array( 'name' => "Pacifico", 'variant' => ''),
	array( 'name' => "Candal", 'variant' => ''),
	array( 'name' => "Architects Daughter", 'variant' => ''),
	array( 'name' => "Indie Flower", 'variant' => ''),
	array( 'name' => "League Script", 'variant' => ''),
	array( 'name' => "Quattrocento", 'variant' => ''),
	array( 'name' => "Amaranth", 'variant' => ''),
	array( 'name' => "Irish Grover", 'variant' => ''),
	array( 'name' => "Oswald", 'variant' => ':400,300,700'),
	array( 'name' => "EB Garamond", 'variant' => ''),
	array( 'name' => "Nova Round", 'variant' => ''),
	array( 'name' => "Nova Slim", 'variant' => ''),
	array( 'name' => "Nova Script", 'variant' => ''),
	array( 'name' => "Nova Cut", 'variant' => ''),
	array( 'name' => "Nova Mono", 'variant' => ''),
	array( 'name' => "Nova Oval", 'variant' => ''),
	array( 'name' => "Nova Flat", 'variant' => ''),
	array( 'name' => "Terminal Dosis Light", 'variant' => ''),
	array( 'name' => "Michroma", 'variant' => ''),
	array( 'name' => "Miltonian", 'variant' => ''),
	array( 'name' => "Miltonian Tattoo", 'variant' => ''),
	array( 'name' => "Annie Use Your Telescope", 'variant' => ''),
	array( 'name' => "Dawning of a New Day", 'variant' => ''),
	array( 'name' => "Sue Ellen Francisco", 'variant' => ''),
	array( 'name' => "Waiting for the Sunrise", 'variant' => ''),
	array( 'name' => "Special Elite", 'variant' => ''),
	array( 'name' => "Quattrocento Sans", 'variant' => ''),
	array( 'name' => "Smythe", 'variant' => ''),
	array( 'name' => "The Girl Next Door", 'variant' => ''),
	array( 'name' => "Aclonica", 'variant' => ''),
	array( 'name' => "News Cycle", 'variant' => ''),
	array( 'name' => "Damion", 'variant' => ''),
	array( 'name' => "Wallpoet", 'variant' => ''),
	array( 'name' => "Over the Rainbow", 'variant' => ''),
	array( 'name' => "MedievalSharp", 'variant' => ''),
	array( 'name' => "Six Caps", 'variant' => ''),
	array( 'name' => "Swanky and Moo Moo", 'variant' => ''),
	array( 'name' => "Bigshot One", 'variant' => ''),
	array( 'name' => "Francois One", 'variant' => ''),
	array( 'name' => "Sigmar One", 'variant' => ''),
	array( 'name' => "Carter One", 'variant' => ''),
	array( 'name' => "Holtwood One SC", 'variant' => ''),
	array( 'name' => "Paytone One", 'variant' => ''),
	array( 'name' => "Monofett", 'variant' => ''),
	array( 'name' => "Rokkitt", 'variant' => ':400,700'),
	array( 'name' => "Megrim", 'variant' => ''),
	array( 'name' => "Judson", 'variant' => ':r,ri,b'),
	array( 'name' => "Didact Gothic", 'variant' => ''),
	array( 'name' => "Play", 'variant' => ':r,b'),
	array( 'name' => "Ultra", 'variant' => ''),
	array( 'name' => "Metrophobic", 'variant' => ''),
	array( 'name' => "Mako", 'variant' => ''),
	array( 'name' => "Shanti", 'variant' => ''),
	array( 'name' => "Caudex", 'variant' => ':r,b,i,bi'),
	array( 'name' => "Jura", 'variant' => ''),
	array( 'name' => "Ruslan Display", 'variant' => ''),
	array( 'name' => "Brawler", 'variant' => ''),
	array( 'name' => "Nunito", 'variant' => ''),
	array( 'name' => "Wire One", 'variant' => ''),
	array( 'name' => "Podkova", 'variant' => ''),
	array( 'name' => "Muli", 'variant' => ''),
	array( 'name' => "Maven Pro", 'variant' => ':400,500,700'),
	array( 'name' => "Tenor Sans", 'variant' => ''),
	array( 'name' => "Limelight", 'variant' => ''),
	array( 'name' => "Playfair Display", 'variant' => ''),
	array( 'name' => "Artifika", 'variant' => ''),
	array( 'name' => "Lora", 'variant' => ''),
	array( 'name' => "Kameron", 'variant' => ':r,b'),
	array( 'name' => "Cedarville Cursive", 'variant' => ''),
	array( 'name' => "Zeyada", 'variant' => ''),
	array( 'name' => "La Belle Aurore", 'variant' => ''),
	array( 'name' => "Shadows Into Light", 'variant' => ''),
	array( 'name' => "Lobster Two", 'variant' => ':r,b,i,bi'),
	array( 'name' => "Nixie One", 'variant' => ''),
	array( 'name' => "Redressed", 'variant' => ''),
	array( 'name' => "Bangers", 'variant' => ''),
	array( 'name' => "Open Sans Condensed", 'variant' => ':300italic,400italic,700italic,400,300,700'),
	array( 'name' => "Open Sans", 'variant' => ':r,i,b,bi'),
	array( 'name' => "Varela", 'variant' => ''),
	array( 'name' => "Goblin One", 'variant' => ''),
	array( 'name' => "Asset", 'variant' => ''),
	array( 'name' => "Gravitas One", 'variant' => ''),
	array( 'name' => "Hammersmith One", 'variant' => ''),
	array( 'name' => "Stardos Stencil", 'variant' => ''),
	array( 'name' => "Love Ya Like A Sister", 'variant' => ''),
	array( 'name' => "Loved by the King", 'variant' => ''),
	array( 'name' => "Bowlby One SC", 'variant' => ''),
	array( 'name' => "Forum", 'variant' => ''),
	array( 'name' => "Patrick Hand", 'variant' => ''),
	array( 'name' => "Varela Round", 'variant' => ''),
	array( 'name' => "Yeseva One", 'variant' => ''),
	array( 'name' => "Give You Glory", 'variant' => ''),
	array( 'name' => "Modern Antiqua", 'variant' => ''),
	array( 'name' => "Bowlby One", 'variant' => ''),
	array( 'name' => "Tienne", 'variant' => ''),
	array( 'name' => "Istok Web", 'variant' => ':r,b,i,bi'),
	array( 'name' => "Yellowtail", 'variant' => ''),
	array( 'name' => "Pompiere", 'variant' => ''),
	array( 'name' => "Unna", 'variant' => ''),
	array( 'name' => "Rosario", 'variant' => ''),
	array( 'name' => "Leckerli One", 'variant' => ''),
	array( 'name' => "Snippet", 'variant' => ''),
	array( 'name' => "Ovo", 'variant' => ''),
	array( 'name' => "IM Fell English", 'variant' => ':r,i'),
	array( 'name' => "IM Fell English SC", 'variant' => ''),
	array( 'name' => "Gloria Hallelujah", 'variant' => ''),
	array( 'name' => "Kelly Slab", 'variant' => ''),
	array( 'name' => "Black Ops One", 'variant' => ''),
	array( 'name' => "Carme", 'variant' => ''),
	array( 'name' => "Aubrey", 'variant' => ''),
	array( 'name' => "Federo", 'variant' => ''),
	array( 'name' => "Delius", 'variant' => ''),
	array( 'name' => "Rochester", 'variant' => ''),
	array( 'name' => "Rationale", 'variant' => ''),
	array( 'name' => "Abel", 'variant' => ''),
	array( 'name' => "Marvel", 'variant' => ':r,b,i,bi'),
	array( 'name' => "Actor", 'variant' => ''),
	array( 'name' => "Delius Swash Caps", 'variant' => ''),
	array( 'name' => "Smokum", 'variant' => ''),
	array( 'name' => "Tulpen One", 'variant' => ''),
	array( 'name' => "Coustard", 'variant' => ':r,b'),
	array( 'name' => "Andika", 'variant' => ''),
	array( 'name' => "Alice", 'variant' => ''),
	array( 'name' => "Questrial", 'variant' => ''),
	array( 'name' => "Comfortaa", 'variant' => ':r,b'),
	array( 'name' => "Geostar", 'variant' => ''),
	array( 'name' => "Geostar Fill", 'variant' => ''),
	array( 'name' => "Volkhov", 'variant' => ''),
	array( 'name' => "Voltaire", 'variant' => ''),
	array( 'name' => "Montez", 'variant' => ''),
	array( 'name' => "Short Stack", 'variant' => ''),
	array( 'name' => "Vidaloka", 'variant' => ''),
	array( 'name' => "Aldrich", 'variant' => ''),
	array( 'name' => "Numans", 'variant' => ''),
	array( 'name' => "Days One", 'variant' => ''),
	array( 'name' => "Gentium Book Basic", 'variant' => ''),
	array( 'name' => "Monoton", 'variant' => ''),
	array( 'name' => "Alike", 'variant' => ''),
	array( 'name' => "Delius Unicase", 'variant' => ''),
	array( 'name' => "Abril Fatface", 'variant' => ''),
	array( 'name' => "Dorsa", 'variant' => ''),
	array( 'name' => "Antic", 'variant' => ''),
	array( 'name' => "Passero One", 'variant' => ''),
	array( 'name' => "Fanwood Text", 'variant' => ''),
	array( 'name' => "Prociono", 'variant' => ''),
	array( 'name' => "Merienda One", 'variant' => ''),
	array( 'name' => "Changa One", 'variant' => ''),
	array( 'name' => "Julee", 'variant' => ''),
	array( 'name' => "Prata", 'variant' => ''),
	array( 'name' => "Adamina", 'variant' => ''),
	array( 'name' => "Sorts Mill Goudy", 'variant' => ''),
	array( 'name' => "Terminal Dosis", 'variant' => ''),
	array( 'name' => "Sansita One", 'variant' => ''),
	array( 'name' => "Chivo", 'variant' => ''),
	array( 'name' => "Spinnaker", 'variant' => ''),
	array( 'name' => "Poller One", 'variant' => ''),
	array( 'name' => "Alike Angular", 'variant' => ''),
	array( 'name' => "Gochi Hand", 'variant' => ''),
	array( 'name' => "Poly", 'variant' => ''),
	array( 'name' => "Andada", 'variant' => ''),
	array( 'name' => "Federant", 'variant' => ''),
	array( 'name' => "Ubuntu Condensed", 'variant' => ''),
	array( 'name' => "Ubuntu Mono", 'variant' => ''),
	array( 'name' => "Sancreek", 'variant' => ''),
	array( 'name' => "Coda", 'variant' => ''),
	array( 'name' => "Rancho", 'variant' => ''),
	array( 'name' => "Satisfy", 'variant' => ''),
	array( 'name' => "Pinyon Script", 'variant' => ''),
	array( 'name' => "Vast Shadow", 'variant' => ''),
	array( 'name' => "Marck Script", 'variant' => ''),
	array( 'name' => "Salsa", 'variant' => ''),
	array( 'name' => "Amatic SC", 'variant' => ''),
	array( 'name' => "Quicksand", 'variant' => ''),
	array( 'name' => "Linden Hill", 'variant' => ''),
	array( 'name' => "Corben", 'variant' => ''),
	array( 'name' => "Creepster Caps", 'variant' => ''),
	array( 'name' => "Butcherman Caps", 'variant' => ''),
	array( 'name' => "Eater Caps", 'variant' => ''),
	array( 'name' => "Nosifer Caps", 'variant' => ''),
	array( 'name' => "Atomic Age", 'variant' => ''),
	array( 'name' => "Contrail One", 'variant' => ''),
	array( 'name' => "Jockey One", 'variant' => ''),
	array( 'name' => "Cabin Sketch", 'variant' => ':r,b'),
	array( 'name' => "Cabin Condensed", 'variant' => ':r,b'),
	array( 'name' => "Fjord One", 'variant' => ''),
	array( 'name' => "Rametto One", 'variant' => ''),
	array( 'name' => "Mate", 'variant' => ':r,i'),
	array( 'name' => "Mate SC", 'variant' => ''),
	array( 'name' => "Arapey", 'variant' => ':r,i'),
	array( 'name' => "Supermercado One", 'variant' => ''),
	array( 'name' => "Petrona", 'variant' => ''),
	array( 'name' => "Lancelot", 'variant' => ''),
	array( 'name' => "Convergence", 'variant' => ''),
	array( 'name' => "Cutive", 'variant' => ''),
	array( 'name' => "Karla", 'variant' => ':400,400italic,700,700italic'),
	array( 'name' => "Bitter", 'variant' => ':r,i,b'),
	array( 'name' => "Asap", 'variant' => ':400,700,400italic,700italic'),
	array( 'name' => "Bree Serif", 'variant' => ''),
    array( 'name' => "Marcellus SC", 'variant' => '' ),
    array( 'name' => "Shadows Into Light", 'variant' => '' )
);

$default_google_fonts = array( 'Open Sans' );