<a href="/admin/{{$zone}}/{{$idItem}}">Edit</a>
<a href="#" onClick="confirmDelete('{{$zone}}',{{$idItem}})">Delete</a>

<script>
    function confirmDelete(zone, idItem)
    {
        let url = "/admin/"+zone+"/"+idItem+"/delete";
        console.log(url);
        if(confirm("Are you sure you wnat to delete this item? This cannot be undone!")) {
            window.location.href = url;
        }
    }
</script>
