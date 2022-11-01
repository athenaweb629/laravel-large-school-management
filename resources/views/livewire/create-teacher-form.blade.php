<div class="card">
    <div class="card-header">
        <h3 class="card-title">Create teacher</h3>
    </div>
    <div class="card-body">
        @if ($includeFormTag = true)
            <form action="{{route('teachers.store')}}" method="POST" enctype="multipart/form-data">
        @endif
                @livewire('create-user-fields', ['role' => 'teacher']) 
                @csrf
                <div class='col-12 my-2'>
                    <x-adminlte-button label="Create" theme="primary" icon="fas fa-key" type="submit" class="col-md-3"/>
                </div>
        @if ($includeFormTag = true)
            </form>
        @endif
    </div>
</div>