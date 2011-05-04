require "rake"
require "sprockets"

JB_ROOT = File.expand_path(File.dirname(__FILE__))
JB_JS_DIR = File.join(JB_ROOT, 'static/js')

MAIN_JS_FILE = File.join(JB_JS_DIR, "whiteboard.js")
  

desc "Make sure the master Sass file is compiled"
task :sass do
  puts `sass static/sass/style.scss style.css --style compressed`
  puts "* Sass compiled to 'style.css'"
end


desc "Strip trailing whitespace and ensure each file ends with a newline"
task :whitespace do
  puts "* Normalizing whitespace ..."
  Dir[JB_JS_DIR + "*", "library/**/*"].each do |filename|
    puts filename
    normalize_whitespace(filename) if File.file?(filename)
  end
end


desc "Concatenate all JS files into single file"
task :concat => :whitespace do
  
  secretary = Sprockets::Secretary.new(
    :load_path => [JB_JS_DIR, File.join(JB_JS_DIR, "library")],
    :source_files => [MAIN_JS_FILE]
  )

  title = (ENV["title"] == nil) ? "all.js" : ENV["title"]

  conc = secretary.concatenation
  conc.save_to("static/js/#{title}")
  puts "* Mashed together all JS files into '#{title}'"

end


desc "Generates a minified version for distribution, using UglifyJS."
task :minify do
  if ENV["FILE"] == nil
    js_file = "all.js"
  else
    js_file = ENV["FILE"]
  end
  
  raise "No FILE given" if js_file == nil
  
  src, target = File.join(JB_JS_DIR, js_file), File.join(JB_JS_DIR, output_filename(js_file))
  uglifyjs src, target
end



# /javascript/application.js => /javascript/application.min.js
def output_filename(js_file)
  output_file = File.basename(js_file, File.extname(js_file))
  output_file = File.join(File.dirname(js_file), output_file)
  return output_file + ".min" + File.extname(js_file)
end


def normalize_whitespace(filename)
  contents = File.readlines(filename)
  contents.each { |line| line.sub!(/\s+$/, "") }
  File.open(filename, "w") do |file|
    file.write contents.join("\n").sub(/(\n+)?\Z/m, "\n")
  end
end


def uglifyjs(src, target)
  begin
    require 'uglifier'
  rescue LoadError => e
    if verbose
      puts "\nYou'll need the 'uglifier' gem for minification. Just run:\n\n"
      puts "  $ gem install uglifier"
      puts "\nand you should be all set.\n\n"
      exit
    end
    return false
  end
  puts "Minifying #{File.basename(src)} with UglifyJS..."
  File.open(target, "w"){|f| f.puts Uglifier.new.compile(File.read(src))}
  puts "* Minified into '#{File.basename(target)}'"
end


