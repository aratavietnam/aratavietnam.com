# Arata Vietnam - Color Palette Documentation

## Brand Colors (Logo Colors)

Bảng màu chính được thiết kế dựa trên 3 màu chính của logo Arata Vietnam:

### Primary Color - Orange (#F55E25)
- **Primary**: `#F55E25` - Màu cam chính của logo
- **Primary Light**: `#F77B4A` - Biến thể sáng hơn
- **Primary Dark**: `#D14A0F` - Biến thể tối hơn

**Sử dụng**: Màu chủ đạo cho buttons, links, highlights, call-to-action elements

### Secondary Color - Blue (#0066A6)
- **Secondary**: `#0066A6` - Màu xanh dương của logo
- **Secondary Light**: `#3385C1` - Biến thể sáng hơn
- **Secondary Dark**: `#004D7A` - Biến thể tối hơn

**Sử dụng**: Màu phụ cho headers, navigation, secondary buttons

### Tertiary Color - Yellow Orange (#FFAB14)
- **Tertiary**: `#FFAB14` - Màu vàng cam của logo
- **Tertiary Light**: `#FFBC43` - Biến thể sáng hơn
- **Tertiary Dark**: `#E6970A` - Biến thể tối hơn

**Sử dụng**: Màu nhấn cho badges, notifications, highlights

## Semantic Colors

### Status Colors
- **Success**: `#10B981` - Màu xanh lá cho thành công
- **Warning**: `#FFAB14` - Màu vàng cam cho cảnh báo (sử dụng tertiary)
- **Error**: `#EF4444` - Màu đỏ cho lỗi
- **Info**: `#0066A6` - Màu xanh dương cho thông tin (sử dụng secondary)

## Neutral Colors

### Base Colors
- **White**: `#FFFFFF` - Màu trắng
- **Black**: `#000000` - Màu đen
- **Dark**: `#1F2937` - Màu tối chính
- **Dark Light**: `#374151` - Biến thể sáng của dark
- **Light**: `#F9FAFB` - Màu sáng chính
- **Light Dark**: `#E5E7EB` - Biến thể tối của light

### Gray Scale
- **Gray 50**: `#F9FAFB` - Rất sáng
- **Gray 100**: `#F3F4F6`
- **Gray 200**: `#E5E7EB`
- **Gray 300**: `#D1D5DB`
- **Gray 400**: `#9CA3AF`
- **Gray 500**: `#6B7280` - Trung tính
- **Gray 600**: `#4B5563`
- **Gray 700**: `#374151`
- **Gray 800**: `#1F2937`
- **Gray 900**: `#111827` - Rất tối

## Usage Guidelines

### WordPress Classes
Các màu có thể được sử dụng thông qua WordPress preset classes:
```css
.has-primary-color { color: #F55E25; }
.has-primary-background-color { background-color: #F55E25; }
.has-secondary-color { color: #0066A6; }
.has-tertiary-color { color: #FFAB14; }
```

### CSS Variables
Sử dụng CSS variables trong theme:
```css
.element {
  color: var(--color-primary);
  background-color: var(--color-secondary);
  border-color: var(--color-tertiary);
}
```

### Tailwind CSS Classes
Với Tailwind CSS v4, các màu sẽ tự động được generate:
```html
<div class="bg-primary text-white">Primary Button</div>
<div class="bg-secondary text-white">Secondary Button</div>
<div class="text-tertiary">Tertiary Text</div>
```

## Accessibility

### Contrast Ratios
- **Primary (#F55E25) on White**: 3.8:1 (AA for large text)
- **Secondary (#0066A6) on White**: 5.2:1 (AA compliant)
- **Tertiary (#FFAB14) on White**: 2.1:1 (Use with caution, prefer dark backgrounds)

### Recommendations
- Sử dụng Primary và Secondary trên nền trắng cho text
- Tertiary nên được sử dụng trên nền tối hoặc cho elements không phải text
- Luôn kiểm tra contrast ratio khi sử dụng màu mới

## Color Combinations

### Recommended Combinations
1. **Primary + White**: Buttons, CTAs
2. **Secondary + White**: Headers, navigation
3. **Tertiary + Dark**: Badges, highlights
4. **Gray 600 + White**: Body text
5. **Gray 400 + White**: Secondary text

### Brand Gradient
```css
.brand-gradient {
  background: linear-gradient(135deg, #F55E25 0%, #0066A6 100%);
}
```

## Implementation

Màu sắc đã được cấu hình trong:
- `themes/aratavietnam/theme.json` - WordPress theme configuration
- `themes/aratavietnam/resources/css/theme.css` - CSS variables
- Tự động tích hợp với Tailwind CSS v4
