@if ($subdomain->domain->enable_ssl && $subdomain->domain->force_https)
    server {
        listen 80;
        server_name {{ $subdomain->name }}.{{ $subdomain->domain->name }};

        return 301 https://{{ $subdomain->name }}.{{ $subdomain->domain->name }}$request_uri;
    }
@endif

server {
    listen      {{ $subdomain->domain->enable_ssl ? '443 ssl' : '80' }};
    server_name {{ $subdomain->name }}.{{ $subdomain->domain->name }};

    @if ($subdomain->domain->enable_ssl)
        ssl_certificate        {{ empty($subdomain->domain->ssl_cert_location) ? config('app.letsencrypt_cert_path').'/'.$subdomain->name.'.'.$subdomain->domain->name.'/fullchain.pem' : $subdomain->domain->ssl_cert_location }};
        ssl_certificate_key    {{ empty($subdomain->domain->ssl_key_location) ? config('app.letsencrypt_cert_path').'/'.$subdomain->name.'.'.$subdomain->domain->name.'/privkey.pem' : $subdomain->domain->ssl_key_location }};
    @endif

    @foreach ($subdomain->locations as $location)
        location {{ trim($location->path) !== '/' ? '~ ^'.trim($location->path).'/?(.*)' : '/' }} {
            @switch($location->type)
                @case('redirect')
                    rewrite ^ {{ trim($location->target) }}{{ trim($location->path) !== '/' ? '/$1' : '' }} redirect;
                    @break
                @case('proxy')
                    proxy_pass {{ trim($location->target) }}{{ trim($location->path) !== '/' ? '/$1$is_args$args' : '' }};

                    proxy_http_version 1.1;

                    proxy_set_header Upgrade           $http_upgrade;
                    proxy_set_header Connection        "upgrade";

                    @if ($location->subtype === 'http')
                        proxy_set_header Host              $host;
                    @endif

                    @if ($location->enable_x_headers)
                        proxy_set_header X-Real-IP         $remote_addr;
                        proxy_set_header X-Forwarded-For   $proxy_add_x_forwarded_for;
                        proxy_set_header X-Forwarded-Proto $scheme;
                        proxy_set_header X-Forwarded-Host  $host;
                        proxy_set_header X-Forwarded-Port  $server_port;
                    @endif

                    proxy_connect_timeout              {{ $location->connect_timeout ?? 60 }}s;
                    proxy_send_timeout                 {{ $location->send_timeout ?? 60 }}s;
                    proxy_read_timeout                 {{ $location->read_timeout ?? 60 }}s;
                    @break
            @endswitch
        }
    @endforeach
}
