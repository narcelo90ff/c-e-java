using Microsoft.EntityFrameworkCore;
public class AppDbContext : DbContext
{
public DbSet<Estudante> Estudantes { get; set; }
protected override void OnConfiguring(DbContextOptionsBuilder options)
=> options.UseMySql("server=localhost;database=escola;user=root;password=123",
ServerVersion.AutoDetect("server=localhost;database=escola;user=root;password=123"));
}
