<?php

if(!function_exists('btn_view')){

    function btn_view($url,$title="View")
    {
        echo '<a href="'.base_url($url).'" class="btn btn-xs btn-primary" title="'.$title.'" data-toggle="tooltip"><i class="fa fa-eye"></i></a>';
    }
}
if(!function_exists('btn_edit')){

    function btn_edit($url,$title="Edit")
    {
        echo '<a href="'.base_url($url).'" class="btn btn-xs btn-warning" title="'.$title.'" data-toggle="tooltip" ><i class="fa fa-edit"></i></a>';
    }
}
if(!function_exists('btn_delete')){

    function btn_delete($url,$title="Delete")
    {
        echo '<a href="'.base_url($url).'" title="'.$title.'" data-toggle="tooltip" onclick="return confirm('.display("are_you_sure").')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a> ';
    }
}
if(!function_exists('btn_add')){

    function btn_add($url,$title="Add")
    {
        echo '<a href="'.base_url($url).'" title="'.$title.'" data-toggle="tooltip" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a> ';
    }
}

?>