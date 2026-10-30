USE looply;

START TRANSACTION;

INSERT INTO categories (name, description)
VALUES
    ('Knitting', 'Projects made with knitting needles.'),
    ('Crochet', 'Projects made with a crochet hook.'),
    ('Embroidery', 'Decorative needlework and thread art.'),
    ('Sewing', 'Handmade projects made with fabric and thread.')
ON DUPLICATE KEY UPDATE
    description = VALUES(description);

INSERT INTO users
    (first_name, last_name, email, password_hash, role, location, bio)
VALUES
    ('Maya', 'Parker', 'maya@example.test', '$2y$10$Lkbm1B/HGm3TZ9zT7m/n6.BpRhnHteiLX1ARiVZXIf.0LezTNjOWq', 'user', 'Portland, OR',
     'Loves soft yarns, quiet mornings, and coastal color palettes.'),
    ('Jonah', 'Reed', 'jonah@example.test', '$2y$10$Lkbm1B/HGm3TZ9zT7m/n6.BpRhnHteiLX1ARiVZXIf.0LezTNjOWq', 'user', 'Brighton, UK',
     'A weekend crocheter collecting useful handmade pieces.'),
    ('Nora', 'Ellis', 'nora@example.test', '$2y$10$Lkbm1B/HGm3TZ9zT7m/n6.BpRhnHteiLX1ARiVZXIf.0LezTNjOWq', 'admin', 'Halifax, NS',
     'Keeps the Looply community organized and welcoming.')
ON DUPLICATE KEY UPDATE
    first_name = VALUES(first_name),
    last_name = VALUES(last_name),
    role = VALUES(role),
    location = VALUES(location),
    bio = VALUES(bio);

SET @maya_id = (SELECT id FROM users WHERE email = 'maya@example.test');
SET @jonah_id = (SELECT id FROM users WHERE email = 'jonah@example.test');
SET @nora_id = (SELECT id FROM users WHERE email = 'nora@example.test');

SET @knitting_id = (SELECT id FROM categories WHERE name = 'Knitting');
SET @crochet_id = (SELECT id FROM categories WHERE name = 'Crochet');
SET @embroidery_id = (SELECT id FROM categories WHERE name = 'Embroidery');
SET @sewing_id = (SELECT id FROM categories WHERE name = 'Sewing');

DELETE FROM projects
WHERE user_id IN (@maya_id, @jonah_id, @nora_id)
  AND title IN (
      'Harbor Mist Cardigan',
      'Market Day Tote',
      'Seaglass Baby Blanket',
      'Linen Tea Towels',
      'Wildflower Hoop'
  );

INSERT INTO projects
    (user_id, category_id, title, description, image_url, privacy)
VALUES
    (@maya_id, @knitting_id, 'Harbor Mist Cardigan',
     'A relaxed cardigan in pale blue wool for cool evenings.',
     'https://images.unsplash.com/photo-1610701596007-11502861dcfa?auto=format&fit=crop&w=900&q=80',
     'public'),
    (@maya_id, @crochet_id, 'Market Day Tote',
     'A sturdy cream and sand tote for library trips and farmers markets.',
     'https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&w=900&q=80',
     'public'),
    (@jonah_id, @crochet_id, 'Seaglass Baby Blanket',
     'A striped blanket using sea glass, dune, and butter tones.',
     'https://images.unsplash.com/photo-1580301762395-21ce6f7a4d1f?auto=format&fit=crop&w=900&q=80',
     'public'),
    (@jonah_id, @sewing_id, 'Linen Tea Towels',
     'Simple linen towels with hand-stitched edging.',
     'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=900&q=80',
     'private'),
    (@nora_id, @embroidery_id, 'Wildflower Hoop',
     'A small hoop featuring coastal wildflowers and grasses.',
     'https://images.unsplash.com/photo-1601924928372-3f1e7f2b1f1d?auto=format&fit=crop&w=900&q=80',
     'public');

SET @cardigan_id = (
    SELECT id FROM projects WHERE user_id = @maya_id AND title = 'Harbor Mist Cardigan'
);
SET @tote_id = (
    SELECT id FROM projects WHERE user_id = @maya_id AND title = 'Market Day Tote'
);
SET @blanket_id = (
    SELECT id FROM projects WHERE user_id = @jonah_id AND title = 'Seaglass Baby Blanket'
);
SET @towels_id = (
    SELECT id FROM projects WHERE user_id = @jonah_id AND title = 'Linen Tea Towels'
);
SET @hoop_id = (
    SELECT id FROM projects WHERE user_id = @nora_id AND title = 'Wildflower Hoop'
);

INSERT INTO reviews
    (project_id, user_id, rating, pattern_source, pattern_url, yarn_used,
     hook_needle_size, notes)
VALUES
    (@cardigan_id, @maya_id, 5, 'Coastal Cardigan pattern',
     'https://example.test/patterns/coastal-cardigan', 'Harbor wool, worsted weight',
     '5 mm needles', 'The construction was clear and the sleeves were easy to adjust.'),
    (@tote_id, @maya_id, 4, 'Market tote tutorial',
     'https://example.test/patterns/market-tote', 'Recycled cotton cord',
     '5 mm hook', 'A quick weekend make with a firm, useful fabric.'),
    (@blanket_id, @jonah_id, 5, 'Seaglass stripes pattern',
     'https://example.test/patterns/seaglass-blanket', 'Cotton-blend DK yarn',
     '4 mm hook', 'The color changes made this especially relaxing to work on.'),
    (@towels_id, @jonah_id, 4, NULL, NULL, 'Natural linen',
     '80/12 needle', 'Pre-washing the fabric made the finished towels softer.'),
    (@hoop_id, @nora_id, 5, 'Wildflower sampler',
     'https://example.test/patterns/wildflower-sampler', 'Six-strand cotton floss',
     'Size 8 embroidery needle', 'A small project with plenty of room for improvisation.');

INSERT INTO favorites (user_id, project_id)
VALUES
    (@jonah_id, @cardigan_id),
    (@jonah_id, @hoop_id),
    (@maya_id, @blanket_id),
    (@nora_id, @cardigan_id),
    (@nora_id, @tote_id)
ON DUPLICATE KEY UPDATE
    created_at = created_at;

COMMIT;
