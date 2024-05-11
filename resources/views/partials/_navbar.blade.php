<div>
    @foreach($categories as $category)
        <div>
            <button id="{{$category->name}}"for="category" > Category: {{$category -> name}}</button>
            <input type="submit" name="category" value="{{$category->getKey()}}"/>
        </div>
    @endforeach
</div>
<div>
    @foreach($categories as $category)
        <div>
            <button id="{{$category->name}}"for="category" > Category: {{$category -> name}}</button>
            <input type="submit" name="category" value="{{$category->getKey()}}"/>
        </div>
    @endforeach
</div>
<div>
    @foreach($categories as $category)
        <div>
            <button id="{{$category->name}}"for="category" > Category: {{$category -> name}}</button>
            <input type="submit" name="category" value="{{$category->getKey()}}"/>
        </div>
    @endforeach
</div>