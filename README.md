Skip to content
Navigation Menu
Excelsior-Technologies-Community
PHP_Laravel12_Mail_Send_Using_API

Type / to search
Code
Issues
Pull requests
Actions
Projects
Security
Insights
Settings
PHP_Laravel12_Mail_Send_Using_API
/
README.md
in
main

Edit

Preview
Indent mode

Spaces
Indent size

4
Line wrap mode

Soft wrap
Editing README.md file contents
Selection deleted
1114
1115
1116
1117
1118
1119
1120
1121
1122
1123
1124
1125
1126
1127
1128
1129
1130
1131
1132
1133
1134
1135
1136
1137
1138
1139
1140
1141
1142
1143
1144
1145
1146
1147
1148
1149
1150
1151
1152
1153
1154
1155
1156
1157
1158
1159
1160
1161
1162
1163
1164
1165
1166
1167
1168
1169
1170
1171
1172
1173
1174
1175
1176
1177
1178
1179
1180
1181
1182
1183
1184
1185
1186
1187
1188
1189
1190
1191
1192
1193
1194
1195
1196
1197
1198
1199
1200
1201
1202
1203
1204
1205
1206
1207
1208
                    Send Another Email
                </a>
                <a href="/mail" class="btn btn-primary mt-3">
                    List Emails
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
```

build() method sets subject and view

9. Run the Application
```

php artisan serve
```
Access:

Web interface: http://localhost:8000/email

API endpoints: http://localhost:8000/api/mail/...



You can use in Postman then show this type:
Send email via API (POST /api/mail/send)

<img width="1905" height="974" alt="Screenshot 2025-12-04 163026" src="https://github.com/user-attachments/assets/c3f308be-43bb-4352-8863-b0d6c412fa8d" />

List emails (GET /api/mail/list)

<img width="1918" height="967" alt="Screenshot 2025-12-04 163129" src="https://github.com/user-attachments/assets/ef1973ab-d3c9-43db-8f0e-ef43b91b96b0" />



View single email (GET /api/mail/view/{id})

<img width="1916" height="982" alt="Screenshot 2025-12-04 163351" src="https://github.com/user-attachments/assets/8b143c7b-464b-4923-b7fc-5c2f5f48387e" />



Soft delete (GET /api/mail/delete/{id})

<img width="1919" height="959" alt="Screenshot 2025-12-04 163508" src="https://github.com/user-attachments/assets/8d3cc32e-8ec2-4bfd-8116-0195ecd21e73" />



Workflow
---
User fills the email form or calls API endpoint.

Email is validated and saved in mail_logs.

Email is sent using Laravel Mailables.

Admin can view all email logs, with pagination.

Soft delete allows temporary deletion and restoration.

Status can be toggled between Active (1) and Inactive (0).

Force delete permanently removes a record from the database.

Commands Summary
```

# 1. Create Laravel 12 project
composer create-project laravel/laravel PHP_Laravel12_Mail_Send_Using_API "^12.0"

# 2. Create migration for mail_logs table
php artisan make:migration create_mail_logs_table --create=mail_logs

# 3. Run migrations
php artisan migrate

# 4. Create Model and Controller
php artisan make:model MailLog -m
php artisan make:controller MailController --resource --model=MailLog

# 5. Create API Controller
php artisan make:controller Api/MailApiController --resource --model=MailLog

# 6. Create Mail Mailable
php artisan make:mail TestMail

# 7. Run Laravel server
php artisan serve
```
 Congratulations!

Use Control + Shift + m to toggle the tab key moving focus. Alternatively, use esc then tab to move to the next interactive element on the page.
No file chosen
Attach files by dragging & dropping, selecting or pasting them.
