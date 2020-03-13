import request from '../utilies/Request'

export function newsletterSave(data) {
    return request({
        url: base_url+'/newsletter',
        method: 'post',
        data: data
    })
}


