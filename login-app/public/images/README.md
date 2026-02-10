# Estrutura de Imagens - Igreja VITÓRIA

## 📁 Organização de Arquivos

### `/images/logos/`
- `logo-principal.svg` - Logo principal usada nos headers
- Dimensões: 300x80px
- Uso: Header de todas as páginas

### `/images/icons/`
- `favicon.svg` - Ícone da aba do navegador
- Dimensões: 32x32px
- Formato: SVG com suporte a gradiente

### `/images/banners/`
- `header-banner.svg` - Banner de boas-vindas
- Dimensões: 1200x300px
- Uso: Background do welcome section

### `/images/avatars/`
- Para fotos de perfil dos usuários
- Formato sugerido: PNG ou JPG
- Dimensões: 200x200px (quadrado)

### `/images/backgrounds/`
- Imagens de fundo para seções especiais
- Formato sugerido: JPG otimizado
- Dimensões: 1920x1080px (full HD)

## 🎨 Guia de Estilo

### Cores da Marca
- Primária: #667eea (Azul roxo)
- Secundária: #764ba2 (Roxo)
- Destaque: #f093fb (Rosa)
- Suporte: #4facfe (Azul claro)

### Gradientes
- Header: linear-gradient(135deg, #667eea 0%, #764ba2 100%)
- Cards: Variados conforme funcionalidade
- Banners: Gradiente tri-color (azul → roxo → rosa)

## 📐 Especificações Técnicas

### Formatos Preferidos
- **Logos**: SVG (escalável)
- **Fotos**: PNG (transparência) ou JPG (otimizado)
- **Ícones**: SVG ou PNG 32x32px
- **Banners**: JPG 80% qualidade

### Otimização
- Comprimir imagens antes de subir
- Usar WebP quando possível
- Lazy loading para imagens grandes
- Alt text obrigatório para acessibilidade

## 🔄 Como Adicionar Novas Imagens

1. Coloque na pasta correspondente
2. Use referência relativa: `/images/pasta/arquivo.ext`
3. Adicione alt text descritivo
4. Teste responsividade

## 📱 Responsividade
- Logos: `h-8 w-auto` (altura fixa)
- Banners: `w-full h-auto` (largura fluida)
- Avatares: `w-12 h-12` (quadrado)
- Ícones: `w-5 h-5` (pequeno)

## 🚀 Uso nas Views Blade

```blade
<!-- Logo principal -->
<img src="/images/logos/logo-principal.svg" alt="Igreja VITÓRIA" class="h-8 w-auto">

<!-- Favicon -->
<link rel="icon" type="image/svg+xml" href="/images/icons/favicon.svg">

<!-- Banner -->
<div style="background-image: url('/images/banners/header-banner.svg')">
```

## 📋 Permissões

Certifique-se de que a pasta tenha as permissões corretas para que o servidor web possa ler as imagens.
