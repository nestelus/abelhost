@extends('layouts.app')

@section('content')
<projects v-bind:data="{{ $projects }}"></projects>

@endsection
