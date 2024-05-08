<?php
namespace App\Interfaces;

interface CrudRepoInterface{
  public function store($request);
  public function show();
  public function update($id,$request);
}
