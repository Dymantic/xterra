<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ url($article['canonical_url']) }}"
  },
  "headline": "{{ $article['title'] }}",
  "description": "{{ $article['description'] }}",
  "image": {
    "@type": "ImageObject",
    "url": "{{ url($article['title_image']['banner']) }}",
    "width": 1800,
    "height": 900
  },
  "author": {
    "@type": "Person",
    "name": "{{ $article['author_name'] }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "XTERRA Taiwan",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ url('/images/logos/nav_logo.svg') }}",
      "width": 300,
      "height": 71
    }
  },
  "datePublished": "{{ $article['first_published_formatted'] }}",
  "dateModified": "{{ $article['publish_date_formatted'] }}"
}
</script>
