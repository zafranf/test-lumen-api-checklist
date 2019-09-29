---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#Authentication


APIs for managing users
<!-- START_b982a9c2785c94e078bbe534a1f12d68 -->
## Login

User login to access application

> Example request:

```bash
curl -X POST "/api/login" 
```

```javascript
const url = new URL("/api/login");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST /api/login`


<!-- END_b982a9c2785c94e078bbe534a1f12d68 -->

#Checklist


APIs for managing users
<!-- START_be54aa6f1cc373e845a562d805ea671c -->
## /api/checklists
> Example request:

```bash
curl -X GET -G "/api/checklists" 
```

```javascript
const url = new URL("/api/checklists");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
null
```

### HTTP Request
`GET /api/checklists`


<!-- END_be54aa6f1cc373e845a562d805ea671c -->

<!-- START_e482d99a75af4543d8260edf2ced8c0f -->
## /api/checklists/{id}
> Example request:

```bash
curl -X GET -G "/api/checklists/1" 
```

```javascript
const url = new URL("/api/checklists/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
null
```

### HTTP Request
`GET /api/checklists/{id}`


<!-- END_e482d99a75af4543d8260edf2ced8c0f -->

<!-- START_bce9be8f3f65faac8e72f175cdcb3f10 -->
## /api/checklists
> Example request:

```bash
curl -X POST "/api/checklists" 
```

```javascript
const url = new URL("/api/checklists");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST /api/checklists`


<!-- END_bce9be8f3f65faac8e72f175cdcb3f10 -->

<!-- START_8ff3f08c06a9a771b1d844ec7cdbf344 -->
## /api/checklists/{id}
> Example request:

```bash
curl -X PATCH "/api/checklists/1" 
```

```javascript
const url = new URL("/api/checklists/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH /api/checklists/{id}`


<!-- END_8ff3f08c06a9a771b1d844ec7cdbf344 -->

<!-- START_4d17267af3ebf0be58845e65e54251b2 -->
## /api/checklists/{id}
> Example request:

```bash
curl -X DELETE "/api/checklists/1" 
```

```javascript
const url = new URL("/api/checklists/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE /api/checklists/{id}`


<!-- END_4d17267af3ebf0be58845e65e54251b2 -->

#Checklist Item


APIs for managing users
<!-- START_d61755dc10e8e6c98f767f57ceb49857 -->
## /api/checklists/items
> Example request:

```bash
curl -X GET -G "/api/checklists/items" 
```

```javascript
const url = new URL("/api/checklists/items");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
null
```

### HTTP Request
`GET /api/checklists/items`


<!-- END_d61755dc10e8e6c98f767f57ceb49857 -->

<!-- START_b20570954c8b2091aa4e211bc2b6a2bb -->
## /api/checklists/{id}/items
> Example request:

```bash
curl -X GET -G "/api/checklists/1/items" 
```

```javascript
const url = new URL("/api/checklists/1/items");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
null
```

### HTTP Request
`GET /api/checklists/{id}/items`


<!-- END_b20570954c8b2091aa4e211bc2b6a2bb -->

<!-- START_6a62c6a764d46fb5af1e300f73340068 -->
## /api/checklists/{id}/items/{item_id}
> Example request:

```bash
curl -X GET -G "/api/checklists/1/items/1" 
```

```javascript
const url = new URL("/api/checklists/1/items/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
null
```

### HTTP Request
`GET /api/checklists/{id}/items/{item_id}`


<!-- END_6a62c6a764d46fb5af1e300f73340068 -->

<!-- START_fe14aef449f4660c6723eebd8b8a5fb2 -->
## /api/checklists/{id}/items
> Example request:

```bash
curl -X POST "/api/checklists/1/items" 
```

```javascript
const url = new URL("/api/checklists/1/items");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST /api/checklists/{id}/items`


<!-- END_fe14aef449f4660c6723eebd8b8a5fb2 -->

<!-- START_ebb41b7ae72029c32173cb84687adc77 -->
## /api/checklists/{id}/items/{item_id}
> Example request:

```bash
curl -X PATCH "/api/checklists/1/items/1" 
```

```javascript
const url = new URL("/api/checklists/1/items/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH /api/checklists/{id}/items/{item_id}`


<!-- END_ebb41b7ae72029c32173cb84687adc77 -->

<!-- START_bd447c7beec6cc0ad5c3e4d83da6e20c -->
## /api/checklists/{id}/items/{item_id}
> Example request:

```bash
curl -X DELETE "/api/checklists/1/items/1" 
```

```javascript
const url = new URL("/api/checklists/1/items/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE /api/checklists/{id}/items/{item_id}`


<!-- END_bd447c7beec6cc0ad5c3e4d83da6e20c -->

<!-- START_8c7a0746ac6b2c24eb5bbcf16e35bca4 -->
## /api/checklists/complete
> Example request:

```bash
curl -X POST "/api/checklists/complete" 
```

```javascript
const url = new URL("/api/checklists/complete");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST /api/checklists/complete`


<!-- END_8c7a0746ac6b2c24eb5bbcf16e35bca4 -->

<!-- START_3271b0429a9f2d71786356141adeac0e -->
## /api/checklists/uncomplete
> Example request:

```bash
curl -X POST "/api/checklists/uncomplete" 
```

```javascript
const url = new URL("/api/checklists/uncomplete");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST /api/checklists/uncomplete`


<!-- END_3271b0429a9f2d71786356141adeac0e -->

#Template


APIs for managing users
<!-- START_dfc628674333e3dac5b1eca58db2532c -->
## /api/templates
> Example request:

```bash
curl -X GET -G "/api/templates" 
```

```javascript
const url = new URL("/api/templates");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
null
```

### HTTP Request
`GET /api/templates`


<!-- END_dfc628674333e3dac5b1eca58db2532c -->

<!-- START_d45c64405e09ff4d747e8050c426358c -->
## /api/templates/{id}
> Example request:

```bash
curl -X GET -G "/api/templates/1" 
```

```javascript
const url = new URL("/api/templates/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
null
```

### HTTP Request
`GET /api/templates/{id}`


<!-- END_d45c64405e09ff4d747e8050c426358c -->

<!-- START_660326cda556bbb834d16212d8c82ef5 -->
## /api/templates
> Example request:

```bash
curl -X POST "/api/templates" 
```

```javascript
const url = new URL("/api/templates");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST /api/templates`


<!-- END_660326cda556bbb834d16212d8c82ef5 -->

<!-- START_e7dd99caca9bf5add81f25fe540472b0 -->
## /api/templates/{id}
> Example request:

```bash
curl -X PATCH "/api/templates/1" 
```

```javascript
const url = new URL("/api/templates/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH /api/templates/{id}`


<!-- END_e7dd99caca9bf5add81f25fe540472b0 -->

<!-- START_4cf693d04903821a77a3d59ee24ce87c -->
## /api/templates/{id}
> Example request:

```bash
curl -X DELETE "/api/templates/1" 
```

```javascript
const url = new URL("/api/templates/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE /api/templates/{id}`


<!-- END_4cf693d04903821a77a3d59ee24ce87c -->


