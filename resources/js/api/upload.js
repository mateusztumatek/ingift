import request from '../utilies/Request'

export function Upload(data, path) {
    return request({
        url: base_url+'/upload/'+path,
        method: 'post',
        data: data
    })
}
