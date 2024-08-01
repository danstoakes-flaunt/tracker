<form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" placeholder="Name" />
    <select name="project">
        @foreach ($projects as $project)
            <option value="{{ $project['id'] }}">{{ $project["name"] }}</option>
        @endforeach
    </select>
    <input type="number" name="hours" placeholder="Hours contracted" />
    <button type="submit">Create</button>
</form>