@extends('backend::layouts._layout')
@section('body')
    <div class="_fwfl title-wrap">
        <h3 class="page-title">Users</h3>
    </div>
    
    <div class="_fwfl _mt20">
        <table class="table table-bordered table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td width="150px">Actions</td>
                </tr>
            </thead>
            <tbody>
                @if($users->count())
                    @php $i = 0; @endphp
                    @foreach($users as $user)
                        @php $i++; @endphp
                        <tr>
                            <td>{{ $i + (($users->currentPage() - 1)  * $maxPerPage) }} </td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                <a href="{{ route('back_user_view', ['id' => $user->id]) }}" class="btn btn-secondary btn-sm">view</a>
                                <button class="btn btn-danger btn-sm">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="_fwfl">
            <nav aria-label="User pagination">
                {{ $users->links('backend::layouts._pagination') }}
            </nav>
        </div>
    </div>
@stop