<?php

/**
 * Configuration CORS pour ImmoGo.
 * Permet à l'application Flutter mobile d'accéder à l'API.
 *
 * Sur Android 9+ : HTTPS requis en production.
 * En développement local : HTTP autorisé via network_security_config.xml côté Flutter.
 */
return [

    /*
     * Chemins concernés par CORS.
     * 'api/*' couvre toutes les routes /api/...
     */
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    /*
     * Méthodes HTTP autorisées.
     */
    'allowed_methods' => ['*'],

    /*
     * Origines autorisées.
     * En production : remplacer '*' par le domaine exact de l'app.
     * Ex : ['https://immogo.app']
     * En dev local : '*' est acceptable.
     */
    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    /*
     * Headers autorisés dans les requêtes entrantes.
     */
    'allowed_headers' => ['*'],

    /*
     * Headers exposés dans la réponse.
     */
    'exposed_headers' => [],

    /*
     * Durée de mise en cache du preflight OPTIONS (secondes).
     */
    'max_age' => 0,

    /*
     * Autoriser les cookies/credentials cross-origin.
     * Mettre à true uniquement si Sanctum avec cookies (web).
     * Pour tokens Bearer mobile : false suffit.
     */
    'supports_credentials' => false,

];
