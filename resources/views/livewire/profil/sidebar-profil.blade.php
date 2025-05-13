<div>
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <a href="{{ route('view.profil', $users->id) }}">
          <img src="{{ $users->profil ? asset('storage/' . $users->profil) :  asset('asset/dist/img/user1-128x128.jpg') }}"
          class="img-circle elevation-2" alt="User Image">
        </a>
      </div>
      <div class="info">
        <a href="{{ route('view.profil', $users->id) }}" class="d-block">{{ $users->name }}</a>
      </div>
      </div>
</div>
