<div class="well">
    @if(isset($has_submit))
        <button class="btn btn-primary">Submit</button>
    @endif
    @if(isset($show))
        <a href="{{action('ConfigsController@getEdit', $type)}}" class="btn btn-default">Edit</a>
    @endif
</div>
