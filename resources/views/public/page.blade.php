  @extends('public/wrapper', ['item' => $itemtags], ['site' => $sitetags])
  @section('title','Slowtown')
  @section('content')

    <page class="site" slug="{{ $slug }}"></page>

  @endsection
