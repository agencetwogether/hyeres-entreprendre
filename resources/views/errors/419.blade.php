@extends('errors::layout')

@section('title', __('app.pages.errors.419.title'))
@section('code', '419')
@section('description', __('app.pages.errors.419.description'))
@section('message', __('app.pages.errors.419.message'))
@section('level', 'warning')
@section('action_return', filament()->getUrl())
