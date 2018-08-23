namespace py gif

struct Gif{
	1: binary data
	2: i32 id
	3: string tag
	4: string nombre
	5: i32 popularidad

}

service Gifsv {

	list<binary> TopGifs(1:string tag),

}
