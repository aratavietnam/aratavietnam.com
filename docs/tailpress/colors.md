# Colors and Styling

Complete guide for managing colors and styling in TailPress themes.

## Color System Overview

TailPress integrates WordPress theme colors with Tailwind CSS, providing a seamless way to manage your theme's color palette through WordPress's theme.json system.

## Default Color Palette

By default, TailPress includes four base colors:

- **Primary**: #2C7FFF (Blue)
- **Secondary**: #FD9A00 (Orange)
- **Dark**: #18181C (Near Black)
- **Light**: #F4F4F5 (Light Gray)

## Managing Colors

### Adding or Modifying Colors

Colors are defined in the `theme.json` file. To modify or add colors:

```json
{
    "version": 3,
    "settings": {
        "color": {
            "palette": [
                {
                    "name": "Primary",
                    "slug": "primary",
                    "color": "#2C7FFF"
                },
                {
                    "name": "Secondary",
                    "slug": "secondary",
                    "color": "#FD9A00"
                },
                {
                    "name": "Dark",
                    "slug": "dark",
                    "color": "#18181C"
                },
                {
                    "name": "Light",
                    "slug": "light",
                    "color": "#F4F4F5"
                },
                {
                    "name": "Custom",
                    "slug": "custom",
                    "color": "#FF0000"
                }
            ]
        }
    }
}
```

### Color Properties

Each color object requires:

- **name**: Human-readable name displayed in the editor
- **slug**: CSS class suffix and variable name
- **color**: Hex, RGB, or HSL color value

## CSS Variable Integration

WordPress automatically generates CSS variables for your colors and injects them into the page head. These variables follow the pattern:

```css
--wp--preset--color--{slug}
```

### Theme CSS Variables

TailPress references these WordPress variables in `resources/css/theme.css`:

```css
:root {
    --color-primary: var(--wp--preset--color--primary);
    --color-secondary: var(--wp--preset--color--secondary);
    --color-dark: var(--wp--preset--color--dark);
    --color-light: var(--wp--preset--color--light);
    --color-custom: var(--wp--preset--color--custom);
}
```

### Updating Theme CSS

When you add new colors or change color names, manually update the `resources/css/theme.css` file to include the new variables:

```css
:root {
    --color-primary: var(--wp--preset--color--primary);
    --color-secondary: var(--wp--preset--color--secondary);
    --color-dark: var(--wp--preset--color--dark);
    --color-light: var(--wp--preset--color--light);
    --color-success: var(--wp--preset--color--success);
    --color-warning: var(--wp--preset--color--warning);
    --color-error: var(--wp--preset--color--error);
}
```

## Using Colors in Templates

### CSS Classes

WordPress generates utility classes for each color:

```html
<!-- Background colors -->
<div class="has-primary-background-color">Primary background</div>
<div class="has-secondary-background-color">Secondary background</div>

<!-- Text colors -->
<p class="has-primary-color">Primary text color</p>
<p class="has-dark-color">Dark text color</p>
```

### CSS Variables

Use CSS variables directly in your stylesheets:

```css
.custom-element {
    background-color: var(--color-primary);
    color: var(--color-light);
    border: 2px solid var(--color-secondary);
}
```

### Tailwind CSS Integration

Extend Tailwind's color palette to include your theme colors:

```css
/* resources/css/app.css */
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
    :root {
        --primary: var(--color-primary);
        --secondary: var(--color-secondary);
    }
}
```

Then use in Tailwind classes:

```html
<div class="bg-[var(--primary)] text-[var(--secondary)]">
    Custom colored element
</div>
```

## Advanced Color Configuration

### Color Variations

Create color variations for different states:

```json
{
    "color": {
        "palette": [
            {
                "name": "Primary",
                "slug": "primary",
                "color": "#2C7FFF"
            },
            {
                "name": "Primary Light",
                "slug": "primary-light",
                "color": "#5A9FFF"
            },
            {
                "name": "Primary Dark",
                "slug": "primary-dark",
                "color": "#1E5FCC"
            }
        ]
    }
}
```

### Semantic Color Names

Use semantic naming for better maintainability:

```json
{
    "color": {
        "palette": [
            {
                "name": "Brand",
                "slug": "brand",
                "color": "#2C7FFF"
            },
            {
                "name": "Accent",
                "slug": "accent",
                "color": "#FD9A00"
            },
            {
                "name": "Success",
                "slug": "success",
                "color": "#10B981"
            },
            {
                "name": "Warning",
                "slug": "warning",
                "color": "#F59E0B"
            },
            {
                "name": "Error",
                "slug": "error",
                "color": "#EF4444"
            }
        ]
    }
}
```

## Block Editor Integration

### Editor Color Palette

Colors defined in theme.json automatically appear in the block editor's color picker, allowing content creators to use your theme colors consistently.

### Disabling Custom Colors

To restrict users to only theme colors:

```json
{
    "settings": {
        "color": {
            "custom": false,
            "palette": [
                // Your color definitions
            ]
        }
    }
}
```

### Color Presets

Define color presets for specific block types:

```json
{
    "settings": {
        "blocks": {
            "core/button": {
                "color": {
                    "palette": [
                        {
                            "name": "Button Primary",
                            "slug": "button-primary",
                            "color": "#2C7FFF"
                        }
                    ]
                }
            }
        }
    }
}
```

## Dark Mode Support

### CSS Variables for Dark Mode

Set up dark mode color variations:

```css
:root {
    --color-text: var(--wp--preset--color--dark);
    --color-background: var(--wp--preset--color--light);
}

@media (prefers-color-scheme: dark) {
    :root {
        --color-text: var(--wp--preset--color--light);
        --color-background: var(--wp--preset--color--dark);
    }
}
```

### Dark Mode Toggle

Implement a dark mode toggle:

```javascript
// resources/js/app.js
function toggleDarkMode() {
    document.documentElement.classList.toggle('dark');
    localStorage.setItem('darkMode', 
        document.documentElement.classList.contains('dark')
    );
}

// Initialize dark mode from localStorage
if (localStorage.getItem('darkMode') === 'true') {
    document.documentElement.classList.add('dark');
}
```

## Color Accessibility

### Contrast Ratios

Ensure adequate contrast ratios for accessibility:

- **Normal text**: Minimum 4.5:1 contrast ratio
- **Large text**: Minimum 3:1 contrast ratio
- **UI elements**: Minimum 3:1 contrast ratio

### Testing Tools

Use tools to verify color accessibility:

- WebAIM Contrast Checker
- Colour Contrast Analyser
- Browser developer tools accessibility features

### WCAG Compliance

Follow WCAG guidelines for color usage:

- Don't rely solely on color to convey information
- Provide alternative indicators (icons, text, patterns)
- Test with color blindness simulators

## Best Practices

### Color Naming

- Use semantic names (primary, secondary, accent)
- Avoid color-specific names (blue, red, green)
- Be consistent across your theme

### Color Hierarchy

- Establish a clear color hierarchy
- Use primary colors sparingly for emphasis
- Maintain consistent color relationships

### Performance

- Minimize the number of color variations
- Use CSS variables for dynamic color changes
- Optimize color definitions for build size

## Troubleshooting

### Colors Not Appearing

1. Check theme.json syntax and formatting
2. Verify CSS variable names match color slugs
3. Clear any caching plugins
4. Regenerate CSS files with `npm run build`

### Block Editor Issues

1. Ensure theme.json is valid JSON
2. Check WordPress version compatibility
3. Verify color palette structure
4. Test with default WordPress theme

### CSS Variable Problems

1. Confirm variables are properly defined
2. Check browser developer tools for CSS errors
3. Verify variable names match theme.json slugs
4. Ensure proper CSS cascade order

## Next Steps

- [Font Management](./fonts.md) - Configure typography
- [Vite Build System](./vite.md) - Optimize asset compilation
- [Theme Structure](./theme-structure.md) - Understand file organization
