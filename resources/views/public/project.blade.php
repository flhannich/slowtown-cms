@extends('public/wrapper', ['item' => $itemtags], ['site' => $sitetags])
@section('title','Slowtown')
@section('content')

  <project class="site" slug="{{ $slug }}"></project>

@endsection
