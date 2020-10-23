<?php

$config = [
	'add_user' => [
		[
			'field' => 'fullname',
			'label' => 'Nama Lengkap',
			'rules' => 'required'
		],
		[
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email|is_unique[pengguna.email]|is_unique[medis.email]'
		],
		[
			'field' => 'nohp',
			'label' => 'Nomor Telp',
			'rules' => 'required'
		],
		[
			'field' => 'jenkel',
			'label' => 'Jenis Kelamin',
			'rules' => 'required|is_numeric'
		],
		[
			'field' => 'level',
			'label' => 'Level',
			'rules' => 'required'
		],
		[
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required|min_length[8]'
		],
		[
			'field' => 'passconf',
			'label' => 'Konfirmasi Password',
			'rules' => 'required|matches[password]'
		]
	],

	'edit_user' => [
		[
			'field' => 'fullname',
			'label' => 'Nama Lengkap',
			'rules' => 'required'
		],
		[
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email|is_unique[medis.email]'
		],
		[
			'field' => 'nohp',
			'label' => 'Nomor Telp',
			'rules' => 'required'
		],
		[
			'field' => 'jenkel',
			'label' => 'Jenis Kelamin',
			'rules' => 'required|is_numeric'
		],
		[
			'field' => 'level',
			'label' => 'Level',
			'rules' => 'required'
		],
	], 

	'edit_user_pass' => [
		[
			'field' => 'fullname',
			'label' => 'Nama Lengkap',
			'rules' => 'required'
		],
		[
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email|is_unique[medis.email]'
		],
		[
			'field' => 'nohp',
			'label' => 'Nomor Telp',
			'rules' => 'required'
		],
		[
			'field' => 'jenkel',
			'label' => 'Jenis Kelamin',
			'rules' => 'required|is_numeric'
		],
		[
			'field' => 'level',
			'label' => 'Level',
			'rules' => 'required'
		],
		[
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required|min_length[8]'
		],
		[
			'field' => 'passconf',
			'label' => 'Konfirmasi Password',
			'rules' => 'required|matches[password]'
		]
	],

	'edit_medis' => [
		[
			'field' => 'fullname',
			'label' => 'Nama Lengkap',
			'rules' => 'required'
		],
		[
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email|is_unique[pengguna.email]'
		],
		[
			'field' => 'nohp',
			'label' => 'Nomor Telp',
			'rules' => 'required'
		],
		[
			'field' => 'jenkel',
			'label' => 'Jenis Kelamin',
			'rules' => 'required|is_numeric'
		],
		[
			'field' => 'level',
			'label' => 'Level',
			'rules' => 'required'
		],
	], 

	'edit_medis_pass' => [
		[
			'field' => 'fullname',
			'label' => 'Nama Lengkap',
			'rules' => 'required'
		],
		[
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email|is_unique[pengguna.email]'
		],
		[
			'field' => 'nohp',
			'label' => 'Nomor Telp',
			'rules' => 'required'
		],
		[
			'field' => 'jenkel',
			'label' => 'Jenis Kelamin',
			'rules' => 'required|is_numeric'
		],
		[
			'field' => 'level',
			'label' => 'Level',
			'rules' => 'required'
		],
		[
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required|min_length[8]'
		],
		[
			'field' => 'passconf',
			'label' => 'Konfirmasi Password',
			'rules' => 'required|matches[password]'
		]
	],

	'tambah_obat' => [
		[
			'field' => 'name',
			'label' => 'Nama Obat',
			'rules' => 'required'
		],
		[
			'field' => 'price',
			'label' => 'Harga Obat',
			'rules' => 'required|is_numeric'
		],
		[
			'field' => 'stock',
			'label' => 'Stok Obat',
			'rules' => 'required|is_numeric'
		]
	],

	'edit_obat' => [
		[
			'field' => 'name',
			'label' => 'Nama Obat',
			'rules' => 'required'
		],
		[
			'field' => 'price',
			'label' => 'Harga Obat',
			'rules' => 'required|is_numeric'
		]
	],

	'validation_layanan' => [
		[
			'field' => 'jenis_layanan',
			'label' => 'Jenis Layanan',
			'rules' => 'required'
		],
		[
			'field' => 'harga',
			'label' => 'Harga',
			'rules' => 'required|is_numeric'
		]
	],

	'validasi_ongkir' => [
		[
			'field' => 'jarak_awal',
			'label' => 'Jarak Awal',
			'rules' => 'required|is_numeric'
		],
		[
			'field' => 'jarak_akhir',
			'label' => 'Jarak Akhir',
			'rules' => 'required|is_numeric'
		],
		[
			'field' => 'biaya',
			'label' => 'Biaya',
			'rules' => 'required|is_numeric'
		]
	],

	'edit_profile' => [
		[
			'field' => 'fullname',
			'label' => 'Nama Lengkap',
			'rules' => 'required'
		],
		[
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email'
		],
		[
			'field' => 'gender',
			'label' => 'Jenis Kelamin',
			'rules' => 'required'
		],
		[
			'field' => 'phone',
			'label' => 'No HP',
			'rules' => 'required|is_numeric'
		]
	],

	'edit_profile_pass' => [
		[
			'field' => 'old-pass',
			'label' => 'Password',
			'rules' => 'required|min_length[4]'
		],
		[
			'field' => 'new-pass',
			'label' => 'Password Baru',
			'rules' => 'required|min_length[4]'
		],
		[
			'field' => 'confirm-pass',
			'label' => 'Konfirmasi Password',
			'rules' => 'required|matches[new-pass]'
		]
	],

	'edit_profile_addr' => [
		[
			'field' => 'provinsi',
			'label' => 'Provinsi',
			'rules' => 'required|is_numeric'
		],
		[
			'field' => 'kabupaten',
			'label' => 'Kabupaten',
			'rules' => 'required|is_numeric'
		],
		[
			'field' => 'kecamatan',
			'label' => 'Kecamatan',
			'rules' => 'required|is_numeric'
		],
		[
			'field' => 'desa',
			'label' => 'Desa',
			'rules' => 'required|is_numeric'
		],
		[
			'field' => 'alamat',
			'label' => 'Alamat',
			'rules' => 'required'
		]
	]
];
