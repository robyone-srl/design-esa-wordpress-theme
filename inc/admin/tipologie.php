<?php

//include tutti i file che descrivono i custom post type del Sito dei Comuni
foreach(glob(get_template_directory() . "/inc/admin/tipologie/*.php") as $file){
	if (
    	!str_contains($file, 'pratica') &&
        !str_contains($file, 'appuntamento') &&
        !str_contains($file, 'documento_privato') &&
        !str_contains($file, 'messaggio') &&
        !str_contains($file, 'pagamento')
    ) {
    	require $file;
	}
}