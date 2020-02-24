import request from "@/utils/request"

export function fetchAllUsers(params) {
  return request({
    url: "/user",
    params,
    method: "get"
  })
}

export function create(data) {
  return request({
    url: "/user/create",
    data,
    method: "post"
  })
}
