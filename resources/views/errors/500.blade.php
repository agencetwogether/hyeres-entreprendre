@extends('errors::layout')

@section('title', __('app.pages.errors.500.title'))
@section('code', '500')
@section('description', __('app.pages.errors.500.description'))
@section('message', __('app.pages.errors.500.message'))
@section('level', 'danger')
@section('action_return', filament()->getUrl())
