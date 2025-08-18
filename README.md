# Arata Vietnam - WordPress Website

Website chính thức của Arata Vietnam - Nền tảng chia sẻ kiến thức và kinh nghiệm về công nghệ, phát triển phần mềm và các xu hướng công nghệ mới nhất tại Việt Nam.

## Quick Start

### Prerequisites
- Docker and Docker Compose installed
- Git installed

### Installation

1. **Clone repository**
```bash
git clone https://github.com/aratavietnam/aratavietnam.com
cd aratavietnam.com
```

2. **Start the Docker containers**
```bash
docker-compose up -d
```

3. **Wait for setup to complete** (about 2-3 minutes)
```bash
docker-compose logs -f wp-cli
```

4. **Access your WordPress site**
- **Website**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/wp-admin
- **Username**: admin
- **Password**: admin123

## What's Included

### Docker Services
- **WordPress**: Latest WordPress version
- **MySQL 8.0**: Database server
- **WP CLI**: Command-line interface for WordPress

### Pre-configured Features
- WordPress installed and configured
- Default content cleaned up (posts, pages, comments, plugins)
- Arata Vietnam theme installed and activated
- Development plugins installed (Query Monitor, Debug Bar)
- Vietnamese timezone configured
- Sample home page created

### Development Tools
- **Query Monitor**: Performance and debugging tool
- **Debug Bar**: Development debugging toolbar
- **WP CLI**: Command-line WordPress management

## WP CLI Commands

Access WP CLI through Docker:
```bash
# List all posts
docker-compose exec wp-cli wp post list --allow-root

# Create a new post
docker-compose exec wp-cli wp post create --post_title="My Post" --post_content="Content" --post_status=publish --allow-root

# Install a plugin
docker-compose exec wp-cli wp plugin install plugin-name --activate --allow-root

# Update WordPress
docker-compose exec wp-cli wp core update --allow-root

# Get help
docker-compose exec wp-cli wp --help --allow-root
```

## Arata Vietnam Theme Development

Theme Arata Vietnam được tự động cài đặt và kích hoạt. Nó nằm tại:
```
./themes/aratavietnam/
```

### Theme Features
- Tailwind CSS integration
- Modern WordPress theme structure
- Vite build system
- Component-based architecture
- Optimized for performance
- Vietnamese language support

### Development Workflow
1. **Theme Development**: Edit files in `./themes/aratavietnam/`
2. **Asset Building**: Use built-in Vite build system
3. **Live Preview**: Changes are reflected immediately in Docker

## Project Structure

```
aratavietnam.com/
├── docker-compose.yml          # Docker configuration
├── wp-cli-setup.sh            # WordPress setup script
├── README.md                  # This file
├── themes/                    # WordPress themes directory
│   └── aratavietnam/          # Arata Vietnam theme
├── plugins/                   # WordPress plugins directory
└── uploads/                   # WordPress uploads directory
```

## Customization

### Environment Variables
Edit `docker-compose.yml` to customize:
- Database credentials
- WordPress URL
- Port mappings
- Volume paths

### WordPress Configuration
The setup script automatically configures:
- Site title and description
- Timezone (Asia/Ho_Chi_Minh)
- Date and time formats
- Front page settings

## Development Work Plan

### Phase 1: Environment Setup
- Docker WordPress environment
- WP CLI integration
- TailPress theme installation
- Development tools setup

### Phase 2: Theme Customization
- Analyze TailPress theme structure
- Customize theme colors and branding
- Create custom page templates
- Implement responsive design
- Add custom post types if needed

### Phase 3: Content & Functionality
- Create site structure and navigation
- Add essential pages (About, Contact, etc.)
- Implement contact forms
- Add SEO optimization
- Set up analytics tracking

### Phase 4: Performance & Security
- Optimize images and assets
- Implement caching strategy
- Security hardening
- Performance testing
- Mobile optimization

### Phase 5: Deployment Preparation
- Production environment setup
- Database migration strategy
- Backup procedures
- Documentation completion

## Useful Commands

### Docker Management
```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# View logs
docker-compose logs -f

# Restart services
docker-compose restart

# Remove everything (including data)
docker-compose down -v
```

### WordPress Management
```bash
# Access WordPress container
docker-compose exec wordpress bash

# Access WP CLI
docker-compose exec wp-cli wp --help --allow-root

# Backup database
docker-compose exec wp-cli wp db export backup.sql --allow-root

# Restore database
docker-compose exec wp-cli wp db import backup.sql --allow-root
```

## Troubleshooting

### Common Issues

1. **Port 8000 already in use**
   ```bash
   # Change port in docker-compose.yml
   ports:
     - "8001:80"  # Use different port
   ```

2. **Database connection issues**
   ```bash
   # Restart database service
   docker-compose restart db
   ```

3. **Theme not loading**
   ```bash
   # Check theme directory permissions
   docker-compose exec wordpress chown -R www-data:www-data /var/www/html/wp-content/themes
   ```

4. **WP CLI not working**
   ```bash
   # Re-run setup script
   docker-compose exec wp-cli /wp-cli-setup.sh
   ```

## Support

For issues related to:
- **Docker setup**: Check Docker logs and documentation
- **WordPress**: Refer to WordPress.org documentation
- **TailPress theme**: Visit [TailPress GitHub](https://github.com/tailpress/tailpress)
- **WP CLI**: Check [WP CLI documentation](https://wp-cli.org/)

## License

This project is licensed under the MIT License - see the LICENSE file for details.
