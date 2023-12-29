@include('components.header')

<nav class="bg-blue-200 p-4 text-black mb-2">
    <ul class="flex space-x-4">
        <h1 class="font-bold mb-0">View magazines</h1>
        <li><a href="{{ route('library.index') }}" class="hover:underline" >(<< back)</a></li>
    </ul>
</nav>

@if (Auth::user() && Auth::user()->role == 'admin')
    <div class="flex justify-center py-0">
        <a href="{{route('magazines.create')}}" class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-black uppercase transition bg-blue-200 rounded shadow ripple hover:shadow-lg hover:bg-blue-400 focus:outline-none">
            Create a magazine
        </a>
    </div>
@endif


<!-- Check if the magazines collection is empty or not -->
@if ($magazines->isEmpty())
    <p>There are no magazines in the library.</p>
@else

    <div class="rounded overflow-hidden shadow my-2 mx-20">
        <table class="w-full text-sm">
            <thead>
            <tr class="text-left font-bold bg-blue-200">
                {{-- <th class="px-2 py-3">ID</th> --}}
                <th class="px-2 py-3 break-words">Title</th>
                <th class="px-2 py-3">Publisher</th>
                <th class="px-2 py-3">ISBN</th>
                <th class="px-2 py-3">Edition</th>
                <th class="px-2 py-3">Year</th>
                <th class="px-2 py-3">Category</th>
                <th class="px-2 py-3 break-words">Description</th>
                <th class="px-2 py-3">Quantity</th>
                <th class="px-2 py-3">Want to borrow?</th>
            </tr>
            </thead>
            <tbody class= "divide-y divide-gray-300">
            @foreach ($magazines as $magazine)
                <tr>
                    {{-- <td class="px-2 py-3">{{ $magazine->id }}</td> --}}
                    <td class="px-2 py-3 break-words">{{ $magazine->title }}</td>
                    <td class="px-2 py-3">{{ $magazine->publisher }}</td>
                    <td class="px-2 py-3">{{ $magazine->isbn }}</td>
                    <td class="px-2 py-3">{{ $magazine->edition }}</td>
                    <td class="px-2 py-3">{{ $magazine->year_published }}</td>
                    <td class="px-2 py-3">{{ $magazine->category }}</td>
                    <td class="px-2 py-3 break-words">{{ $magazine->description }}</td>
                    <td class="px-2 py-3">{{ $magazine->quantity }}</td>
                    <td class="px-2 py-3">

                        @if (Auth::check() && Auth::user()->role == 'admin')
                            {{-- Edit magazine button (only for admin) --}}
                            <form action="{{ route('magazines.edit', $magazine) }}" method="get" class="mb-2">
                                <button type="submit" class="w-full bg-blue-200 hover:bg-blue-400 text-black font-bold py-2 px-4 rounded-lg">Edit</button>
                            </form>

                            {{-- Delete magazine button (only for admin) --}}
                            <form action="{{ route('magazines.destroy', $magazine) }}" method="post" class="mb-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-blue-200 hover:bg-blue-400 text-black font-bold py-2 px-4 rounded-lg">Delete</button>
                            </form>
                        @elseif (Auth::check() && Auth::user()->role == 'user')
                            @if (!Auth::user()->borrowings->where('borrowable_type', 'App\Models\Magazine')->contains('borrowable_id', $magazine->id))
                                {{-- Borrow magazine button --}}
                                <form action="{{ route('magazines.borrow', $magazine) }}" method="post" class="mb-2">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="days" class="block text-center text-sm italic font-medium text-gray-700"> Number of days:</label>
                                        
                                        <input type="number" name="days" id="days" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md border-gray-950 border" required>
                                    </div>
                                    <button type="submit" class="w-full bg-blue-200 hover:bg-blue-400 text-black font-bold py-2 px-4 rounded-lg">Borrow</button>
                                </form>
                            @else
                                    <p type="submit" class="w-full bg-gray-200 text-black font-bold py-2 px-4 rounded-lg text-center">Already Borrowed</p>
                            @endif

                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif

