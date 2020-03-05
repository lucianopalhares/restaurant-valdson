@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            <button type="button" aria-hidden="true" class="close" onclick="this.parentElement.style.display='none'">×</button>
            <span>
              <ul style="list-style-type: none">
                  @foreach ($errors->all() as $error)
                     @if(is_array($error)&&count($error)>0)
                        @foreach ($error as $erro)
                          <li>{{ $erro }}</li>
                        @endforeach
                     @else
                      <li>{{ $error }}</li>
                     @endif
                  @endforeach
              </ul>              
            </span>
        </div>
    @endforeach
@endif


@if(session('successMsg'))
    <div class="alert alert-success">
        <button type="button" aria-hidden="true" class="close" onclick="this.parentElement.style.display='none'">×</button>
        <span>
                {{ session('successMsg') }}</span>
    </div>
@endif

    
@if(session('error'))
        <div class="alert alert-danger">
            <button type="button" aria-hidden="true" class="close" onclick="this.parentElement.style.display='none'">×</button>
            <span>
              {!! session('error') !!}
            </span>
        </div>
@endif


  