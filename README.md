# projecte2

*** BACKEND REQUESTS ***

*DESTINACIONS*

/api/destinacions/read.php - GET - Envies un read=ALL per rebre un array de totes les ofertes, 
                                    un read=continents per rebre un array de continents, i 
                                    continent=idcontinent per rebre un array dels paisos del continent

    params : read=ALL 
    return :    'continents' => array de destinacions,
                'status' => 'OK'

    params : read=continents
    return :    'continents' => array de continents,
                'status' => 'OK'

    params : continent=idcontinent
    return :    'paisos' => array de destinacions del continent,
                'status' => 'OK'

*OFERTES*

/api/ofertes/read.php - GET - Envies un read=ALL per rebre un array de totes les ofertes

    params: read=ALL
    return:     'ofertes' => array de ofertes,
                'status' => 'OK'

/api/ofertes/create.php - POST - Envies les dades per fer un insert a la taula ofertes 

    params: desti, preupersona, datainici, datafi
    return: 'success' => true o 'error' => true

/api/ofertes/delete.php - POST - Envies l'id de la oferta a eliminar de la taula ofertes

    params: id
    return: 'success' => true o 'error' => true

*RESERVES*

/api/reserves/read.php - GET - Envies un read=ALL per rebre un array de totes les reserves

    params: read=ALL
    return:     'reserves' => array de reserves,
                'status' => 'OK'

/api/reserves/create.php - POST - Envies les dades per fer un insert a la taula reserves 

    params: idoferta, nomclient, telefon, npersones, descompte, datareserva
    return: 'success' => true o 'error' => true

/api/reserves/delete.php - POST - Envies l'id de la reserva a eliminar de la taula reserves

    params: id
    return: 'success' => true o 'error' => true
