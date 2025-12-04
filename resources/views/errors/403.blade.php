@extends('errors::minimal')

@section('title', __('Helaas heeft u geen toegang tot deze pagina. Neemt contact op met de beheerder als u van mening bent dat u wel toegang tot deze pagina moet hebben'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Geen toegang tot deze pagina'))
