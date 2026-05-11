<div style="padding: 20px; font-family: sans-serif;">
    <h2>Manajemen User (Admin Only)</h2>
    <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse;">
        <tr style="background: #f4f4f4;">
            <th>Nama</th>
            <th>Email</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->role == 0) Admin @elseif($user->role == 1) Pembina @else Anggota @endif
            </td>
            <td>
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <select name="role">
                        <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Anggota</option>
                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Pembina</option>
                        <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Admin</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>