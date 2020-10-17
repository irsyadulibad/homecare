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
	]
];
