using Microsoft.EntityFrameworkCore;
using ProjetoPedidos.Models;

namespace ProjetoPedidos.Data;

public class AppDbContext : DbContext
{
    public DbSet<Pedido> Pedidos { get; set; }
    public DbSet<ItemPedido> ItensPedidos { get; set; }

    protected override void OnConfiguring(DbContextOptionsBuilder options)
        => options.UseSqlite("Data Source=pedidos.db");

    protected override void OnModelCreating(ModelBuilder modelBuilder)
    {
        // Configura relacionamento 1:N explicitamente
        modelBuilder.Entity<ItemPedido>()
            .HasOne(i => i.Pedido)
            .WithMany(p => p.Itens)
            .HasForeignKey(i => i.PedidoId);

        // ✅ Precisão decimal para valores monetários
        modelBuilder.Entity<ItemPedido>()
            .Property(i => i.PrecoUnitario)
            .HasColumnType("decimal(10,2)");
    }
}
