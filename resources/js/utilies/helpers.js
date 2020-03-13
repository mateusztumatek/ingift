export function serialize(obj) {
    var str = [];
    for (var p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}
export function downloadURI(uri, name) {
    var link = document.createElement('a');
    link.download = name;
    link.id = 'tmp_link';
    link.href = uri;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    document.getElementById('tmp_link').remove();
}
