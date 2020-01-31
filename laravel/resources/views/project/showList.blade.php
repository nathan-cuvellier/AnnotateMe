<div class="container">
    <h2 class="text-center my-3">Search project</h2>
    <div class="row">
        <div class="col-md">
            <div class="d-flex justify-content-center">
                <form class="form-inline" method="GET" action="{{ route('project.list') }}">
                    <div class="form-group">
                        <input type="text" class="form-control" name="search" placeholder="Search"
                               value="{{ $_GET['search'] ?? '' }}">
                    </div>
                    <div class="form-group mx-2">
                        <select name="interface" id="interface" class="form-control">
                            <option value="default">All interface types</option>
                            @foreach($interfaces as $interface)
                                <option value="{{ $interface->id_int }}" <?= isset($_GET['interface']) && $interface->id_int == $_GET['interface'] ? 'selected' : '' ?>>
                                    {{ $interface->label_int }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mx-2">
                        <select class="form-control" name="sessionMode" id="sessionMode">
                            <option value="">All limitation modes</option>
                            @foreach($sessionsMode as $sessionMode)
                                <option value="{{ $sessionMode->id_mode }}" <?= isset($_GET['sessionMode']) && $sessionMode->id_mode == $_GET['sessionMode'] ? 'selected' : '' ?>>
                                    {{ $sessionMode->label_mode }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mx-2">
                        <input type="submit" class="btn btn-primary" name="searchSend" value="search">
                    </div>
                    <div class="form-group mx-2">
                        <input type="submit" class="btn btn-primary" name="reset" value="reset">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<hr class="my-4">
<div class="container">
    @if($search == true)
        <div class="alert alert-warning w-50 mx-auto" role="alert">
            <p class="text-center m-0">{{ count($projectsList) }} project(s) found</b></p>
        </div>
    @endif
    @if(session()->has('warning'))
        <div class="alert alert-warning w-50 mx-auto" role="alert">
            <p class="text-center m-0"><b>{{ session('warning') }}</b></p>
        </div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success w-50 mx-auto" role="alert">
            <p class="text-center m-0"><b>{{ session('success') }}</b></p>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger w-50 mx-auto" role="alert">
            <p class="text-center m-0"><b>{{ session('error') }}</b></p>
        </div>
    @endif

    <div class="d-flex justify-content-start flex-wrap">
        @foreach($projectsList as $project)
            <div class="w-30 mx-2 mt-4">
                <div class="card h-100">
                    <h5 class="card-header text-nowrap text-truncate">@if(!$project->online_prj) [OFFLINE] @endif {{ str_replace('_', ' ', $project->name_prj) }}</h5>
                    <div class="card-body">
                        <h5 class="card-title">{{ $project->label_int }}</h5>
                        @if(!is_null($project->desc_prj))
                            @if(strlen($project->desc_prj) > 100)
                                <p class="card-text">{{ substr($project->desc_prj,0,100) }}...</p>
                            @else
                                <p class="card-text">{{ $project->desc_prj }}</p>
                            @endif
                        @else
                            <p class="card-text"><i>The project has no description...</i></p>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('project.read', ['id' => $project->id_prj]) }}"
                           class="w-100 btn btn-primary">Go</a>
                    </div>
                </div>
            </div>

        @endforeach
    </div>
</div>