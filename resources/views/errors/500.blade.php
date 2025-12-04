@extends('errors::minimal')

@section('title', __('Er is een onbekend foutmelding opgetreden, De beheerder is op de hoogte gesteld'))
@section('code', '500')
@section('message', __($exception->getMessage() ?: 'Er is een onbekende fout opgetreden. De beheerder is van deze foutmelding op de hoogte gesteld.'))
