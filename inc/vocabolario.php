<?php

/**
 * Vocabolario controllato che raccoglie un subset dei vocaboli definiti in Eurovoc
 */
if(!function_exists("dci_argomenti_array")){
    function dci_argomenti_array() {
        $argomenti_arr = [
            "Accesso all'informazione",
            "Aiuto a domicilio",
            "Anzianità",
            "Appalto di lavori",
            "Assistenza agli anziani",
            "Assistenza sanitaria",
            "Assistenza sociale",
            "Assunzione",
            "Bilancio",
            "Cittadino",
            "Comunicazione istituzionale",
            "Concorsi",
            "Covid-19",
            "Cure palliative",
            "Famiglia",
            "Formazione del personale",
            "Lavoro",
            "Servizio civile",
            "Transizione digitale",
            "Trasparenza amministrativa",
            "Vita sociale",
            "Volontariato",
            "Anziano",
            "Protezione dei dati / Privacy",
            "Contratto pubblico",
            "Qualità del prodotto",
            "Sicurezza del lavoro",
            "Sicurezza degli edifici"
        ];
        return $argomenti_arr;
    }
}

/**
 * Classificazione multi livello dei tipi di Unità organizzativa che distingue tra macro ambiti di un'amministrazione locale
 */
if(!function_exists("dci_tipi_unita_organizzativa_array")){
    function dci_tipi_unita_organizzativa_array() {
        $tipi_unita_organizzativa_arr = [
            'struttura amministrativa' => [
                'area',
                'ufficio'
            ],
            'struttura di governo e controllo' => [
                'consiglio di amministrazione',
                'collegio dei revisori',
                'nucleo di valutazione'
            ],
            'altra struttura' => [
                'biblioteca',
                'museo',
                'azienda partecipata',
                'ente',
                'fondazione',
                'scuola',
                'centro culturale',
            ]
        ];
        return $tipi_unita_organizzativa_arr;
    }
}

/**
 * Classificazione delle materie dei Servizi pubblici, definita nel Vocabolario controllato sulle Materie dei servizi Pubblici
 */
if(!function_exists("dci_categorie_servizio_array")){
    function dci_categorie_servizio_array() {
        $categorie_servizio_arr = [
            'Servizi socio-assistenziali',
			'Assistenza amministrativa',
			'Servizi integrativi',
			'Servizi aggiuntivi'
        ];
        return $categorie_servizio_arr;
    }
}

/**
 * Classificazione delle Licenze dei dataset secondo il Vocabolario Controllato Licenze
 */
if(!function_exists("dci_licenze_array")){
    function dci_licenze_array() {
        $licenze_arr = [
            'licenza aperta' => [
                'pubblico dominio',
                'attribuzione',
                'effetto virale',
                'condivisione allo stesso modo - copyleft non compatibile',
            ],
            'non aperta' => [
                'solo uso non commerciale',
                'non opere derivate'
            ],
            'licenza sconosciuta',
        ];
        return $licenze_arr;
    }
}

/**
 * Classificazione dei Temi dei dati secondo il Vocabolario Controllato Temi dei dati
 */
if(!function_exists("dci_temi_dataset_array")){
    function dci_temi_dataset_array() {
        $temi_dataset_arr = [
            'Acquisti',
            'Socio-assistenza',
            'Economia e finanze'
        ];
        return $temi_dataset_arr;
    }
}

/**
 * Classificazione della Frequenza di aggiornamento secondo il Vocabolario Controllato Frequenza
 */
if(!function_exists("dci_frequenze_aggiornamento_array")){
    function dci_frequenze_aggiornamento_array() {
        $frequenze_aggiornamento_arr = [
            'altro',
            'annuale',
            'bidecennale',
            'biennale',
            'bimensile',
            'bimestrale',
            'bisettimanale',
            'continuo',
            'decennale',
            'due volte al giorno',
            'in continuo aggiornamento',
            'irregolare',
            'mai',
            'mensile',
            'ogni cinque anni',
            'ogni due ore',
            'ogni ora',
            'ogni quattro anni',
            'ogni tre ore',
            'quindicinale',
            'quotidiano',
            'sconosciuto',
            'semestrale',
            'settimanale',
            'tre volte a settimana',
            'tre volte al mese',
            'tre volte all\'anno',
            'tridecennale',
            'triennale',
            'trimestrale'
        ];
        return $frequenze_aggiornamento_arr;
    }
}

/**
 * Classificazione dei Tipi di Punti di contatto riprendendo le Linee Guida Cataloghi dei dati
 */
if(!function_exists("dci_tipi_punto_contatto_array")){
    function dci_tipi_punto_contatto_array() {
        $tipi_punto_contatto_arr = [
            'Indirizzo',
            'Email',
            'Telefono',
            'URL',
            'PEC',
            'Account' => [
                'Whatsapp',
                'Telegram',
                'Skype',
                'Linkedin',
                'Twitter',
            ]
        ];
        return $tipi_punto_contatto_arr;
    }
}

/**
 * Classificazione multi livello dei Documenti che sono di tipo Albo Pretorio
 */
if(!function_exists("dci_tipi_doc_albo_pretorio_array")){
    function dci_tipi_doc_albo_pretorio_array() {
        $tipi_doc_albo_pretorio_arr = [
            'Atto amministrativo' => [
                'Decreto' => [
                    'Decreto del Dirigente',
                    'Decreto del Presidente'
                ],
                'Deliberazione' => [
                    'Deliberazione del Consiglio di amministrazione',
                    'Deliberazione di altri Organi'
                ],
                'Determinazione' => [
                    'Determinazione del Direttore',
                    'Determinazione del Dirigente'
                ],
                'Parere consultivo' => [
                    'Parere del Collegio dei revisori'
                ]
            ],
            'Atto autorizzativo',
            'Atto generico' => [
                'Avviso' => [
                    'Avviso di deposito',
                    'Avviso/Manifesto'
                ],
                'Bando' => [
                    'Bando di concorso',
                    'Bando di gara',
                    'Bando di contributi e vantaggi economici'
                ]
            ],
            'Pubblicazione esterna' => [
                'Atto di terzi' => [
                    'Atto di terzi'
                ]
            ],
        ];
        return $tipi_doc_albo_pretorio_arr;
    }
}

/**
 *Classificazione degli Eventi della vita delle persone (Life Events), definita nel Vocabolario controllato degli eventi della vita delle persone. Aggiornato al 17/03/2022
 */
if(!function_exists("dci_eventi_vita_persone_array")){
    function dci_eventi_vita_persone_array() {
        $eventi_vita_persone_arr = [
            'Iscrizione Scuola/Università e/o richiesta borsa di studio',
            'Invalidità',
            'Ricerca di lavoro, avvio nuovo lavoro, disoccupazione',
            'Pensionamento',
            'Richiesta o rinnovo patente',
            'Registrazione o possesso veicolo',
            'Accesso al trasporto pubblico',
            'Compravendita/affitto casa/edifici/terreni, costruzione o ristrutturazione casa/edificio',
            'Cambio di residenza o domicilio',
            'Espatri oper lavoro, studio o pensionamento',
            'Richiesta passaporto, visto e assistenza viaggi internazionali',
            'Nascita di un bambino, richiesta adozioni',
            'Matrimonio e/o cambio stato civile',
            'Morte ed eredità',
            'Prenotazione e disdetta visite/esami',
            'Denuncia crimini',
            'Dichiarazione dei redditi, versamento e riscossione tributi/imposte e contributi',
            'Accesso ai luoghi della cultura',
            'Possesso, cura, smarrimento animale da compagnia'
        ];
        return $eventi_vita_persone_arr;
    }
}

/**
 *Classificazione degli Eventi della vita di un'impresa (Business Events), definita nel Vocabolario controllato degli eventi di business (evento della vita di un'impresa). Aggiornato al 17/03/2022
 */
if(!function_exists("dci_eventi_vita_impresa_array")){
    function dci_eventi_vita_impresa_array() {
        $eventi_vita_impresa_arr = [
            'Avvio impresa',
            'Avvio nuova attività professionale',
            'Richiesta licenze, permessi e certificati',
            'Registrazione impresa transfrontaliera',
            'Avviso e registrazione filiale',
            'Finanziamento impresa',
            'Gestione personale',
            'Pagamento iva, tasse e dogane',
            'Notifiche autorità',
            'Chiusura impresa e attività professionale',
            'Chiusura filiale',
            'Ristrutturazione impresa',
            'Vendita impresa',
            'Bancarotta',
            'Partecipazione ad appalti pubblici nazionali e transfrontalieri'
        ];
        return $eventi_vita_impresa_arr;
    }
}

/**
 *Classificazione multi livello dei Tipi di incarico che una persona può ricoprire presso un'amministrazione locale
 */
if(!function_exists("dci_tipi_incarico_array")){
    function dci_tipi_incarico_array() {
        $tipi_incarico_arr = [
            'politico',
            'amministrativo',
            'sanitario',
            'socio-assistenziale',
            'altro'
        ];
        return $tipi_incarico_arr;
    }
}

/**
 *Classificazione multi livello degli Stati di una Pratica
 */
if(!function_exists("dci_stati_pratica_array")){
    function dci_stati_pratica_array() {
        $stati_pratica_arr = [
            'Processo non avviato' => [
                'In bozza'
            ],
            'Processo in corso',
            'Processo sospeso' => [
                'Si richiede un’azione da parte dell\'utente',
                'Si richiede un\'azione da parte della Pubblica Amministrazione'
            ],
            'Processo concluso' => [
                'Esito positivo',
                'Esito negativo'
            ]
        ];
        return $stati_pratica_arr;
    }
}

/**
 * Classificazione multi livello delle Notizie pubblicate da un'amministrazione locale
 */
if(!function_exists("dci_tipi_notizia_array")){
    function dci_tipi_notizia_array() {
        $tipi_notizia_arr = [
            'Notizie',
            'Comunicati',
            'Avvisi'
        ];
        return $tipi_notizia_arr;
    }
}

/**
 * Classificazione multi livello dei Luoghi di interesse pubblico, definita nella Tassonomia dei luoghi pubblici di interesse culturale
 */
if(!function_exists("dci_luoghi_array")){
    function dci_luoghi_array() {
        $luoghi_arr = [
            'Architettura Militare e fortificata' => [
                'Castello',
                'Fortezza',
                'Mura',
                'Roccaforte',
                'Torre'
            ],
            'Architettura Residenziale' => [
                'Trullo',
                'Villa',
                'Palazzo'
            ],
            'Area archeologica' => [
                'Sito archeologico',
                'Parco archeologico'
            ],
            'Centro per la cultura'=>[
                'Acquario',
                'Anfiteatro',
                'Archivio',
                'Auditorium',
                'Biblioteca',
                'Cinema',
                'Galleria',
                'Museo',
                'Osservatorio',
                'Pinacoteca',
                'Planetario',
                'Scuola',
                'Teatro',
                'Università/Facoltà',
                'Parco Archeologico',
            ],
            'Edificio di culto'=>[
                'Abbazia',
                'Chiesa',
                'Campanile',
                'Battistero',
                'Convento',
                'Duomo',
                'Edicola',
                'Eremo',
                'Mausoleo',
                'Monastero',
                'Santuario',
                'Sinagoga',
                'Tempio',
                'Sepolcro',
                'Basilica',
                'Cappella',
                'Catacomba',
                'Cattedrale',
                'Cimitero'
            ],
            'Monumento o complesso monumentale' => [
                'Archi',
                'Colonna',
                'Complesso monumentale',
                'Monumento',
                'Obelisco'
            ],
            'Parco e giardino' => [
                'Belvedere',
                'Parco',
                'Giardino',
                'Viale'
            ],
            'Bellezza naturale' => [
                'Costa marittima',
                'Lago',
                'Corso d’acqua',
                'Montagna',
                'Ghiacciaio',
                'Riserva Naturale',
                'Foresta e bosco',
                'Vulcano',
            ],
            'Luogo per lo sport e il tempo libero' => [
                'Campo sportivo',
                'Piscina',
                'Stadio',
                'Terme',
                'Casinò',
                'Circolo sportivo',
                'Piazza'
            ],
            'Architettura commerciale' => [
                'Mercati',
                'farmacie'
            ],
            'Centro per l\'assistenza e la tutela sociale' => [
                'Casa di riposo',
                'Centro di accoglienza',
                'Ospedale',
                'Locali per servizio assistenziale',
                'Locali per servizio educativo',
                'Locali per servizio di ristorazione'
            ],
            'Infrastruttura e impianto' => [
                'Centro di raccolta',
                'Acquedotto',
                'Aeroporto',
                'Porto'
            ],
            'Struttura ricettiva' => [
                'Albergo',
                'Foresteria',
                'Rifugio',
                'Rifugio per animali'
            ],
        ];
        return $luoghi_arr;
    }
}

/**
 * Classificazione multi livello degli Eventi di interesse pubblico, definita nella Tassonomia degli eventi di interesse pubblico
 */
if(!function_exists("dci_tipi_evento_array")){
    function dci_tipi_evento_array() {
        $tipi_evento_arr = [
            'Evento culturale'=> [
                'Manifestazione artistica' => [
                    'Festival',
                    'Mostra',
                    'Spettacolo teatrale',
                    'Spettacolo di danza',
                    'Manifestazione musicale',
                    'Visita guidata',
                    'Lettura (pubblica)',
                    'Proiezione cinematografica',
                    'Visita libera',
                ],
                'Evento di formazione' => [
                    'Scuola estiva/invernale',
                    'Webinar',
                    'Seminario',
                    'Laboratorio',
                    'Presentazione libro',
                    'Corso'
                ],
                'Conferenza e Summit' => [
                    'Convegno',
                    'Vertice',
                    'Congresso'
                ],
                'Giornata Informativa' => [
                    'Giornata aperta'
                ]
            ],
            'Evento sociale'=> [
                'Concorso e cerimonia' => [
                    'Cerimonia',
                    'Concorso/competizione'
                ],
                'Dibattito pubblico' => [
                    'Dibattito/dialogo pubblico',
                    'Forum'
                ],
                'Incontro con esperti' => [
                    'Riunione esperti',
                    'Hackathon / Datathon'
                ],
                'Raduno di comunità' => [
                    'Sfilata',
                    'Sagra',
                    'Torneo storico o Palio',
                    'Festa Patronale o dei santi',
                    'Mercatino',
                    'Commemorazione',
                ],
                'Evento religioso' => [
                    'Giubileo',
                    'Udienza giubiliare',
                    'Processione',
                    'Celebrazione religiosa',
                    'Lettura religiosa',
                    'Raduno religioso',
                    'Santificazione',
                ]
            ],
            'Evento politico'=> [
                'Incontro pubblico' => [
                    'Congresso o riunione di partito',
                    'Corteo o sciopero',
                    'Comizio elettorale'
                ]
            ],
            'Evento di affari o commerciale'=> [
                'Fiera o Salone' => [
                    'Fiera o Salone',
                    'Esposizione o Esposizione globale'
                ],
                'Riunione d\'affari' => [
                    'Riunione d’affari',
                    'Convention',
                    'Tavola rotonda'
                ],
                'Evento stagionale commerciale' => [
                    'Vendita di fine stagione'
                ]
            ],
            'Evento Sportivo'=> [
                'Manifestazione sportiva' => [
                    'Partita',
                    'Gara o Torneo o Competizione',
                    'Escursione',
                    'Galà sportivo',
                    'Corsa',
                    'Raduno sportivo',
                ]
            ]
        ];
        return $tipi_evento_arr;
    }
}

/**
 * Classificazione dei tipi di documento, definita nel Vocabolario Controllato Tipi di Documenti delle Pubbliche Amministrazioni
 */
if(!function_exists("dci_tipi_documento_array")){
    function dci_tipi_documento_array() {
        $tipi_documento_arr = [
            'Documento Albo Pretorio',
            'Modulistica',
            'Documento funzionamento interno',
            'Atto normativo',
            'Accordo tra enti',
            'Documento attività politica',
            'Documento (tecnico) di supporto',
            'Istanza',
            'Documento di programmazione e rendicontazione',
            'Dataset'
        ];
        return $tipi_documento_arr;
    }
}

/**
 * Plurali dei tipi di documento,
 */
if(!function_exists("dci_tipi_documento_plural_array")){
    function dci_tipi_documento_plural_array() {
        $tipi_documento_plural_arr = [
            'Documento Albo Pretorio' => 'Documenti Albo Pretorio',
            'Modulistica' => 'Modulistica',
            'Documento funzionamento interno' => 'Documenti funzionamento interno',
            'Atto normativo' => 'Atti normativi',
            'Accordo tra enti' => 'Accordi tra enti',
            'Documento attività politica' => 'Documenti attività politica',
            'Documento (tecnico) di supporto' => 'Documenti (tecnici) di supporto',
            'Istanza' => 'Istanze',
            'Documento di programmazione e rendicontazione' => 'Documenti di programmazione e rendicontazione',
            'Dataset' => 'Dataset'
        ];
        return $tipi_documento_plural_arr;
    }
}

/**
 * descrizioni dei termini della tassonomia Categorie di Servizio
 */
if(!function_exists('dci_get_tipi_documento_descriptions_array')){
    function dci_get_tipi_documento_descriptions_array(){
        $tipi_documento_descriptions_arr = [
            'Documento Albo Pretorio' => 'Gli atti amministrativi per i quali è previsto l\'obbligo di pubblicità legale.',
            'Modulistica' => 'Tutti i moduli predisposti per la stesura di documenti o scritture.',
            'Documento funzionamento interno' => 'I regolamenti interni, i provvedimenti dirigenziali e i codici disciplinari degli organi di indirizzo politico.',
            'Atto normativo' => 'Statuto, regolamenti dell\'ente e altre norme ufficiali.',
            'Accordo tra enti' => 'Gli accordi dell\'ente con altre istituzioni, fondazioni ed enti.',
            'Documento attività politica' => 'Sedute, ordini del giorno e interrogazioni degli organi di governo comunali.',
            'Documento (tecnico) di supporto' => 'Qualunque documento, anche di natura tecnica, pubblicato dall\'amministrazione ',
            'Istanza' => 'Le richieste private rivolte agli organi amministrativi o giurisdizionali dell\'ente.',
            'Documento di programmazione e rendicontazione' => 'Rendiconti, procedure, bilanci consuntivi e preventivi.',
            'Dataset' => 'Le statistiche e i dati strutturati riguardanti le attività produttive, la qualità della vita e la popolazione dell\'ente.'
        ];
        return $tipi_documento_descriptions_arr;
    }
}

/**
 * descrizioni dei termini della tassonomia Tipi di Documento
 */
if(!function_exists('dci_get_categorie_servizio_descriptions_array')){
    function dci_get_categorie_servizio_descriptions_array(){
        $categorie_servizio_descriptions_arr = [
            'Servizi socio-assistenziali' => 'La struttura, nell\'ambito dei suoi obiettivi e delle possibilità di assistenza, offre servizi socio-assistenziali come la residenzialità, la semi-residenzialità, i ricoveri temporanei e l\'assistenza domiciliare',
			'Assistenza amministrativa' => 'Servizi orientati ad agevolare le persone nelle pratiche amministrative',
			'Servizi integrativi' => 'Servizi complementari alla socio-assistenza come l\'animazione, la ristorazione e la pulizia degli ambienti',
			'Servizi aggiuntivi' => 'Servizi offerti anche alle persone che non intendono risiedere nella struttura'
            ];
        return $categorie_servizio_descriptions_arr;
    }
}


/**
 * Vocabolario immagini degli argomenti
 */
if(!function_exists("dci_get_immagini_argomenti_array")){
    function dci_get_immagini_argomenti_array() {
        $argomenti_arr = [
			'Volontariato' => 'volontariato',
        ];
        return $argomenti_arr;
    }
}