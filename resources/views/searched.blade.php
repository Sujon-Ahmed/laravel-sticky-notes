@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mt-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <a href="{{ route('home') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Notes List" style="color: #000"><i class="fa fa-list fa-2x"></i></a>
                        <span class="newNotes" data-bs-toggle="tooltip" data-bs-placement="top" title="New Note"><i
                                style="cursor: pointer" class="fa fa-plus-circle fa-2x"></i></span>
                        <form action="{{ route('search') }}" method="GET">
                            <div class="input-group">
                                <input type="search" name="search_note" id="search_note" class="form-control"
                                    placeholder="Search..." aria-label="search" aria-describedby="addon-wrapping"
                                    value="{{ old('search_note') }}" style="width: 300px">
                                <button type="submit" class="input-group-text" id="addon-wrapping"><i
                                        class="fa fa-search"></i></button>
                            </div>
                        </form>
                        <span class="float-right userProfile" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Profile"><i style="cursor: pointer" class="fa fa-user-circle fa-2x"></i></span>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @forelse ($notes as $item)
                            <div class="card mb-2  note-content">                            
                                <div class="card-body note-body">                                    
                                    <span class="float-right note-time">{{ $item->created_at->diffForHumans() }}</span>
                                    <span class="float-right note-menu">
                                        {{-- <i class="fa fa-ellipsis-h"></i>
                                        <div class="options">
                                            <a href="#">Edit</a>
                                            <a href="#">Delete</a>
                                        </div> --}}
                                        <li class="nav-item dropdown">
                                            <span class="float-right note-menu nav-link" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="options"></i></span>                                            
                                            <ul class="dropdown-menu">
                                              <li><button type="button" value="{{ $item->id }}" class="dropdown-item noteEditBtn">Edit</button></li>
                                              <li><button type="button" value="{{ $item->id }}" class="dropdown-item noteDeleteBtn">Delete</button></li>
                                            </ul>
                                          </li>
                                    </span>
                                    <p><?= $item->note ?>   </p>                                 
                                </div>
                            </div>
                        @empty
                            <em>There are no Sticky Notes Found!</em>
                        @endforelse
                        <br>
                        {{-- {{ $notes->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- modal for new notes --}}
        <div class="modal fade" id="newNotes" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Below Write Your Valuable Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('note.store') }}" method="POST">
                        <div class="modal-body">
                            @csrf
                            <textarea id="summernote" name="note"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- modal for profile information view --}}
        <div class="modal fade" id="profileModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">User Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3>Name : {{ Auth::user()->name }}</h3>
                        <h5>Email : {{ Auth::user()->email }}</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        {{-- <button type="submit" class="btn btn-primary btn-sm">Save changes</button> --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- modal for delete confirm message show modal --}}
        <div class="modal fade" id="viewDeleteNoteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Message</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('note.delete') }}" method="POST">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="noteDeletedId" id="noteDeletedId">
                            <h5>Are You Sure Delete This Note?</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger btn-sm">Yes! Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- modal for edit notes --}}
        <div class="modal fade" id="editNoteModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit / Updated Your Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ url('/note/updated') }}" method="POST">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="editNoteId" id="editNoteId">
                            <textarea id="editSummernote" name="editNote"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // script for tooltip
            {
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
            // script for summernote
            {
                $('#summernote').summernote({
                    placeholder: 'Write here...',
                    tabsize: 2,
                    height: 200
                });
                $('#editSummernote').summernote({
                    placeholder: 'Write here...',
                    tabsize: 2,
                    height: 200
                });
            }
            // script for new note add modal
            $('.newNotes').click(function(e) {
                e.preventDefault();
                $('#newNotes').modal('show');
            });
            // script for profile view modal
            $('.userProfile').click(function(e) {
                e.preventDefault();
                $('#profileModal').modal('show');
            });
            // script for delete modal 
            $('.noteDeleteBtn').click(function (e) { 
                e.preventDefault();
                let noteDeletedId = $(this).val();
                $('#viewDeleteNoteModal').modal('show');
                $('#noteDeletedId').val(noteDeletedId);
            });
            // edit note modal
            $('.noteEditBtn').click(function (e) { 
                e.preventDefault();
                let editNoteId = $(this).val();
                $('#editNoteModal').modal('show');
                // $('#editSummernote').text();
                $.ajax({
                    type: "GET",
                    url: "/getNoteInfo/" + editNoteId,
                    dataType: "json",
                    success: function (response) {
                        console.log(response.note_info.note);
                        $('#editNoteId').val(editNoteId);
                        // $('#editSummernote').html(response.note_info.note);
                        $('#editSummernote').summernote('code',response.note_info.note);
                    }
                });
            });
        });
    </script>
@endsection
