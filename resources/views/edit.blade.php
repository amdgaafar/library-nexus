<h1>Edit Book</h1>

<form action="{{ route('books.update', $book) }}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ $book->title }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
