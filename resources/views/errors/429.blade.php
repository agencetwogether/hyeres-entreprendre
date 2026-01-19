@extends('errors::layout')

@section('title', __('app.pages.errors.429.title'))
@section('code', '429')
@section('description', __('app.pages.errors.429.description'))
@section('message', __('app.pages.errors.429.message'))
@section('level', 'danger')
@section('action_return', filament()->getUrl())
