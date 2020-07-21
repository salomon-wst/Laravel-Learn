@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users List</div>

                <div class="table-responsive card-body">
                    <table class="table   table-bordered">
                        <tr>
                            <td>SN</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Address</td>
                            <td>Image</td>
                            <td>Status</td>
                        </tr>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td class="text-capitalize">{{ $user['name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>{{ $user['address'] }}</td>
                                    <td><img class="avatar" src="{{ $user['image'] }}" alt="">
                                    </td>
                                    <td>
                                        @if($user['active']==1)
                                            <input type="checkbox" value="{{ $user['id'] }}"
                                                class="user_active" checked="checked" />
                                        @else
                                            <input type="checkbox" value="{{ $user['id'] }}"
                                                class="user_active" />
                                        @endif

                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
