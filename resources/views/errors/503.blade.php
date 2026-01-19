@extends('errors::layout')

@section('title', __('app.pages.errors.503.title'))
@section('code', '503')
@section('description', __('app.pages.errors.503.description'))
@section('message', __('app.pages.errors.503.message'))
@section('level', 'danger')
@section('action_return', filament()->getUrl())
